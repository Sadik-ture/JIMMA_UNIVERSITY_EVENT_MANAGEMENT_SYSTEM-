<?php
// app/Http/Controllers/FeedbackController.php
namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\FeedbackCategory;
use App\Models\Event;
use App\Models\User;
use App\Services\FeedbackService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    protected $feedbackService;

    public function __construct(FeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
        // Apply auth middleware to admin methods only
        $this->middleware('auth')->only([
            'index', 'show', 'updateStatus', 'addResponse', 
            'togglePublic', 'toggleFeatured', 'analytics', 'export'
        ]);
    }

    // ========== PUBLIC ROUTES ==========
    public function create(Request $request)
    {
        $event = null;
        if ($request->filled('event_id')) {
            $event = Event::findOrFail($request->event_id);
        }
        
        $categories = FeedbackCategory::active()->ordered()->get();
        
        return view('feedback.create', compact('event', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'nullable|exists:events,id',
            'type' => 'required|in:event,system,general,suggestion,complaint',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10|max:2000',
            'rating' => 'nullable|integer|min:1|max:5',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:feedback_categories,id',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'allow_contact' => 'boolean',
            'is_public' => 'boolean',
        ]);
        
        if (Auth::check()) {
            $validated['user_id'] = Auth::id();
        }
        
        $feedback = $this->feedbackService->submitFeedback($validated);
        
        return redirect()->route('feedback.thankyou')
            ->with('success', 'Thank you for your feedback!');
    }

    public function thankyou()
    {
        return view('feedback.thankyou');
    }

    public function testimonials(Request $request)
    {
        $query = Feedback::public()->with('event', 'user');
        
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }
        
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }
        
        if ($request->filled('featured')) {
            $query->featured();
        }
        
        $testimonials = $query->orderBy('created_at', 'desc')->paginate(12);
        
        $averageRating = Feedback::public()->withRating()->avg('rating');
        $totalTestimonials = Feedback::public()->count();
        
        return view('feedback.testimonials', compact('testimonials', 'averageRating', 'totalTestimonials'));
    }

    // ========== ADMIN ROUTES ==========
    public function index(Request $request)
    {
        // Check if user has permission
        if (!auth()->user()->hasPermission('view_feedback')) {
            abort(403, 'This action is unauthorized.');
        }
        
        $query = Feedback::with(['event', 'user', 'assignee', 'categories']);
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
        }
        
        if ($request->filled('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }
        
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->rating);
        }
        
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('subject', 'like', "%{$request->search}%")
                  ->orWhere('message', 'like', "%{$request->search}%")
                  ->orWhereHas('user', function ($q) use ($request) {
                      $q->where('name', 'like', "%{$request->search}%");
                  });
            });
        }
        
        $feedbacks = $query->orderBy('created_at', 'desc')->paginate(20);
        
        $statistics = [
            'total' => Feedback::count(),
            'pending' => Feedback::pending()->count(),
            'reviewed' => Feedback::reviewed()->count(),
            'resolved' => Feedback::resolved()->count(),
        ];
        
        $categories = FeedbackCategory::active()->ordered()->get();
        
        return view('feedback.index', compact('feedbacks', 'statistics', 'categories'));
    }

    public function show(Feedback $feedback)
    {
        if (!auth()->user()->hasPermission('view_feedback')) {
            abort(403, 'This action is unauthorized.');
        }
        
        $feedback->load(['event', 'user', 'assignee', 'categories', 'responses.responder']);
        
        return view('feedback.show', compact('feedback'));
    }

    public function updateStatus(Request $request, Feedback $feedback)
    {
        if (!auth()->user()->hasPermission('update_feedback')) {
            abort(403, 'This action is unauthorized.');
        }
        
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewed,resolved,closed',
            'admin_notes' => 'nullable|string',
            'resolution_notes' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        
        $feedback->update($validated);
        
        if ($validated['status'] === 'reviewed' && !$feedback->reviewed_at) {
            $feedback->update(['reviewed_at' => now()]);
        }
        
        if ($validated['status'] === 'resolved' && !$feedback->resolved_at) {
            $feedback->update(['resolved_at' => now()]);
        }
        
        return redirect()->route('feedback.admin.show', $feedback)
            ->with('success', 'Feedback status updated');
    }

    public function addResponse(Request $request, Feedback $feedback)
    {
        if (!auth()->user()->hasPermission('respond_feedback')) {
            abort(403, 'This action is unauthorized.');
        }
        
        $validated = $request->validate([
            'message' => 'required|string|min:10|max:2000',
            'send_email' => 'boolean',
        ]);
        
        $response = $this->feedbackService->sendResponse(
            $feedback,
            $validated['message'],
            $validated['send_email'] ?? false
        );
        
        return redirect()->route('feedback.admin.show', $feedback)
            ->with('success', 'Response added successfully');
    }

    public function togglePublic(Request $request, Feedback $feedback)
    {
        if (!auth()->user()->hasPermission('update_feedback')) {
            abort(403, 'This action is unauthorized.');
        }
        
        $feedback->update(['is_public' => !$feedback->is_public]);
        
        return response()->json([
            'success' => true,
            'is_public' => $feedback->is_public,
        ]);
    }

    public function toggleFeatured(Request $request, Feedback $feedback)
    {
        if (!auth()->user()->hasPermission('update_feedback')) {
            abort(403, 'This action is unauthorized.');
        }
        
        if (!$feedback->is_public) {
            return response()->json([
                'success' => false,
                'message' => 'Only public feedback can be featured',
            ], 422);
        }
        
        $feedback->update(['featured' => !$feedback->featured]);
        
        return response()->json([
            'success' => true,
            'featured' => $feedback->featured,
        ]);
    }

    public function analytics()
    {
        if (!auth()->user()->hasPermission('view_feedback_analytics')) {
            abort(403, 'This action is unauthorized.');
        }
        
        // Calculate statistics
        $total = Feedback::count();
        $withRating = Feedback::whereNotNull('rating')->count();
        $averageRating = Feedback::whereNotNull('rating')->avg('rating');
        $averageRating = $averageRating ? round($averageRating, 2) : 0;
        
        // Status breakdown
        $statusBreakdown = [
            'pending' => Feedback::pending()->count(),
            'reviewed' => Feedback::reviewed()->count(),
            'resolved' => Feedback::resolved()->count(),
            'closed' => Feedback::where('status', 'closed')->count(),
        ];
        
        // Type breakdown
        $typeBreakdown = [
            'event' => Feedback::where('type', 'event')->count(),
            'system' => Feedback::where('type', 'system')->count(),
            'general' => Feedback::where('type', 'general')->count(),
            'suggestion' => Feedback::where('type', 'suggestion')->count(),
            'complaint' => Feedback::where('type', 'complaint')->count(),
        ];
        
        // Monthly trend (last 6 months)
        $monthlyTrend = Feedback::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw("COUNT(*) as count")
            )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Top rated events
        $topRatedEvents = Feedback::select('event_id', DB::raw('AVG(rating) as avg_rating'))
            ->whereNotNull('event_id')
            ->whereNotNull('rating')
            ->groupBy('event_id')
            ->orderBy('avg_rating', 'desc')
            ->with('event')
            ->limit(5)
            ->get();
        
        // Recent feedback
        $recentFeedbacks = Feedback::with('event', 'user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('feedback.analytics', compact(
            'total',
            'withRating',
            'averageRating',
            'statusBreakdown',
            'typeBreakdown',
            'monthlyTrend',
            'topRatedEvents',
            'recentFeedbacks'
        ));
    }

    public function export(Request $request)
    {
        if (!auth()->user()->hasPermission('export_feedback')) {
            abort(403, 'This action is unauthorized.');
        }
        
        return $this->feedbackService->exportFeedback($request->all(), $request->get('format', 'excel'));
    }
}