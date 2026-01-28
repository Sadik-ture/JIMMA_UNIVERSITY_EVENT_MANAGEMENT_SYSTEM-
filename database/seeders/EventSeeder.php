<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'title' => 'Annual Science Conference 2024',
                'description' => 'Join us for the annual science conference featuring keynote speakers from around the world. Topics include AI, biotechnology, and environmental science.',
                'start_date' => now()->addDays(10)->setTime(9, 0),
                'end_date' => now()->addDays(12)->setTime(17, 0),
                'venue' => 'Main Auditorium',
                'campus' => 'Main Campus',
                'event_type' => 'conference',
                'organizer' => 'Science Department',
                'contact_email' => 'science@ju.edu.et',
                'contact_phone' => '+251 47 111 2201',
                'max_attendees' => 500,
                'registered_attendees' => 320,
                'is_featured' => true,
                'requires_registration' => true,
                'registration_link' => 'https://forms.example.com/science-conf',
                'tags' => ['science', 'conference', 'research'],
            ],
            [
                'title' => 'Cultural Day Celebration',
                'description' => 'Experience the rich cultural heritage of Ethiopia through music, dance, and traditional food. Open to all students and staff.',
                'start_date' => now()->addDays(5)->setTime(14, 0),
                'end_date' => now()->addDays(5)->setTime(22, 0),
                'venue' => 'Student Union Building',
                'campus' => 'Main Campus',
                'event_type' => 'cultural',
                'organizer' => 'Student Affairs',
                'contact_email' => 'culture@ju.edu.et',
                'max_attendees' => 1000,
                'registered_attendees' => 850,
                'is_featured' => true,
            ],
            [
                'title' => 'Inter-Campus Football Tournament',
                'description' => 'Annual football tournament between different campuses. Cheer for your campus team!',
                'start_date' => now()->addDays(15)->setTime(8, 0),
                'end_date' => now()->addDays(17)->setTime(18, 0),
                'venue' => 'University Stadium',
                'campus' => 'Sports Campus',
                'event_type' => 'sports',
                'organizer' => 'Sports Department',
                'contact_phone' => '+251 47 111 2203',
                'requires_registration' => true,
                'tags' => ['sports', 'football', 'tournament'],
            ],
            [
                'title' => 'AI and Machine Learning Workshop',
                'description' => 'Hands-on workshop on AI and machine learning fundamentals. Suitable for beginners.',
                'start_date' => now()->addDays(3)->setTime(10, 0),
                'end_date' => now()->addDays(3)->setTime(16, 0),
                'venue' => 'Computer Lab 3',
                'campus' => 'Technology Campus',
                'event_type' => 'workshop',
                'organizer' => 'Computer Science Department',
                'contact_email' => 'cs@ju.edu.et',
                'max_attendees' => 50,
                'registered_attendees' => 48,
                'requires_registration' => true,
                'is_featured' => true,
                'tags' => ['ai', 'workshop', 'technology'],
            ],
            [
                'title' => 'Academic Writing Seminar',
                'description' => 'Learn effective academic writing techniques for research papers and publications.',
                'start_date' => now()->addDays(7)->setTime(9, 0),
                'end_date' => now()->addDays(7)->setTime(13, 0),
                'venue' => 'Library Conference Room',
                'campus' => 'Main Campus',
                'event_type' => 'seminar',
                'organizer' => 'Research Office',
                'max_attendees' => 100,
                'registered_attendees' => 75,
            ],
            [
                'title' => 'Entrepreneurship Summit',
                'description' => 'Connect with successful entrepreneurs and learn about startup opportunities.',
                'start_date' => now()->addDays(20)->setTime(8, 30),
                'end_date' => now()->addDays(21)->setTime(17, 0),
                'venue' => 'Business School Auditorium',
                'campus' => 'Business Campus',
                'event_type' => 'conference',
                'organizer' => 'Business School',
                'contact_email' => 'business@ju.edu.et',
                'max_attendees' => 300,
                'registered_attendees' => 280,
                'requires_registration' => true,
                'tags' => ['business', 'entrepreneurship', 'networking'],
            ],
            [
                'title' => 'Art Exhibition: Modern Ethiopian Art',
                'description' => 'Exhibition showcasing contemporary Ethiopian artists. Free admission.',
                'start_date' => now()->addDays(1)->setTime(10, 0),
                'end_date' => now()->addDays(30)->setTime(18, 0),
                'venue' => 'University Art Gallery',
                'campus' => 'Arts Campus',
                'event_type' => 'cultural',
                'organizer' => 'Fine Arts Department',
                'is_featured' => true,
            ],
            [
                'title' => 'Health and Wellness Fair',
                'description' => 'Free health checkups, nutrition advice, and wellness workshops.',
                'start_date' => now()->addDays(8)->setTime(9, 0),
                'end_date' => now()->addDays(8)->setTime(16, 0),
                'venue' => 'Medical Center Grounds',
                'campus' => 'Medical Campus',
                'event_type' => 'workshop',
                'organizer' => 'Medical School',
                'contact_phone' => '+251 47 111 2205',
                'tags' => ['health', 'wellness', 'medical'],
            ],
        ];

        foreach ($events as $eventData) {
            $slug = Str::slug($eventData['title']);
            
            // Check if event already exists
            if (!Event::where('slug', $slug)->exists()) {
                $eventData['slug'] = $slug;
                Event::create($eventData);
            }
        }
    }
}