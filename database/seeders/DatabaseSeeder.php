<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Skill;
use App\Models\File;
use App\Models\Message;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        // Create some regular users
        $users = [];
        
        for ($i = 1; $i <= 5; $i++) {
            $users[] = User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);
        }

        // Create skills
        $skills = [
            // Programming skills
            ['name' => 'PHP', 'category' => 'Programming'],
            ['name' => 'JavaScript', 'category' => 'Programming'],
            ['name' => 'Python', 'category' => 'Programming'],
            ['name' => 'Java', 'category' => 'Programming'],
            ['name' => 'C++', 'category' => 'Programming'],
            
            // Design skills
            ['name' => 'UI Design', 'category' => 'Design'],
            ['name' => 'UX Design', 'category' => 'Design'],
            ['name' => 'Graphic Design', 'category' => 'Design'],
            
            // Project Management skills
            ['name' => 'Agile', 'category' => 'Project Management'],
            ['name' => 'Scrum', 'category' => 'Project Management'],
            ['name' => 'Kanban', 'category' => 'Project Management'],
            
            // Communication skills
            ['name' => 'Technical Writing', 'category' => 'Communication'],
            ['name' => 'Presentation', 'category' => 'Communication'],
            
            // Database skills
            ['name' => 'MySQL', 'category' => 'Database'],
            ['name' => 'PostgreSQL', 'category' => 'Database'],
            ['name' => 'MongoDB', 'category' => 'Database'],
        ];

        $skillModels = [];
        foreach ($skills as $skill) {
            $skillModels[] = Skill::create($skill);
        }

        // Assign random skills to users
        foreach ($users as $user) {
            $randomSkills = array_rand(array_flip(range(0, count($skillModels) - 1)), rand(3, 8));
            foreach ($randomSkills as $skillIndex) {
                $user->skills()->attach($skillModels[$skillIndex]->id, [
                    'proficiency_level' => rand(1, 5)
                ]);
            }
        }

        // Also give admin some skills
        $adminSkills = array_rand(array_flip(range(0, count($skillModels) - 1)), 5);
        foreach ($adminSkills as $skillIndex) {
            $admin->skills()->attach($skillModels[$skillIndex]->id, [
                'proficiency_level' => rand(3, 5)
            ]);
        }

        // Create some projects
        $projects = [
            [
                'title' => 'Web Development Final Project',
                'description' => "This is a group project for the Web Development course. We need to create a full-stack web application using modern technologies.\n\nRequirements:\n- Frontend using React, Vue, or Angular\n- Backend using Node.js or PHP\n- Database integration\n- User authentication\n- Mobile-responsive design",
                'start_date' => now()->subDays(30),
                'end_date' => now()->addDays(60),
                'status' => 'in_progress',
                'is_public' => true,
                'creator_id' => $admin->id,
            ],
            [
                'title' => 'Mobile App Development',
                'description' => "Developing a cross-platform mobile application for our Mobile Development class. We'll be using React Native or Flutter.\n\nProject Goals:\n- Create a user-friendly interface\n- Implement real-time data synchronization\n- Use native device features (camera, location, etc.)\n- Deploy to both iOS and Android platforms",
                'start_date' => now()->subDays(15),
                'end_date' => now()->addDays(45),
                'status' => 'planning',
                'is_public' => true,
                'creator_id' => $users[0]->id,
            ],
            [
                'title' => 'Data Science Research Project',
                'description' => "Analyzing a large dataset to identify patterns and make predictions for our Data Science course.\n\nProject Scope:\n- Data cleaning and preprocessing\n- Exploratory data analysis\n- Feature engineering\n- Model building and evaluation\n- Final presentation of findings",
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(25),
                'status' => 'planning',
                'is_public' => true,
                'creator_id' => $users[1]->id,
            ],
            [
                'title' => 'Computer Graphics Final Assignment',
                'description' => "Creating a 3D scene with animation for our Computer Graphics course. We'll be using OpenGL or WebGL.\n\nRequired Elements:\n- 3D modeling of objects\n- Texture mapping\n- Lighting and shadows\n- Camera movement\n- Basic physics simulation",
                'start_date' => now()->addDays(10),
                'end_date' => now()->addDays(40),
                'status' => 'planning',
                'is_public' => false,
                'creator_id' => $users[2]->id,
            ],
        ];

        $projectModels = [];
        foreach ($projects as $project) {
            $projectModel = Project::create($project);
            $projectModels[] = $projectModel;
            
            // Add creator as project owner
            $projectModel->members()->attach($projectModel->creator_id, ['role' => 'owner']);
            
            // Add some random members
            $memberCount = rand(1, 3);
            $potentialMembers = $users;
            
            // Remove creator from potential members
            $potentialMembers = array_filter($potentialMembers, function($user) use ($projectModel) {
                return $user->id !== $projectModel->creator_id;
            });
            
            $randomMembers = array_rand(array_flip(array_keys($potentialMembers)), min($memberCount, count($potentialMembers)));
            
            if (!is_array($randomMembers)) {
                $randomMembers = [$randomMembers];
            }
            
            foreach ($randomMembers as $memberIndex) {
                $projectModel->members()->attach($potentialMembers[$memberIndex]->id, ['role' => rand(0, 1) ? 'member' : 'pending']);
            }
            
            // Create tasks for each project
            $taskCount = rand(5, 10);
            for ($i = 1; $i <= $taskCount; $i++) {
                $status = ['to_do', 'in_progress', 'review', 'completed'][rand(0, 3)];
                $priority = ['low', 'medium', 'high'][rand(0, 2)];
                
                // Only assign completed tasks or a random subset of other tasks
                $assignedTo = null;
                if ($status === 'completed' || rand(0, 1)) {
                    $projectMembers = $projectModel->members()->wherePivot('role', '!=', 'pending')->get();
                    if ($projectMembers->count() > 0) {
                        $assignedTo = $projectMembers->random()->id;
                    }
                }
                
                $task = Task::create([
                    'title' => "Task $i for " . $projectModel->title,
                    'description' => "This is a sample task description for task $i. It provides details about what needs to be done to complete the task successfully.",
                    'project_id' => $projectModel->id,
                    'assigned_to' => $assignedTo,
                    'created_by' => $projectModel->creator_id,
                    'due_date' => now()->addDays(rand(1, 30)),
                    'priority' => $priority,
                    'status' => $status,
                ]);
                
                // Add some comments to tasks
                if (rand(0, 1)) {
                    $commentCount = rand(1, 3);
                    for ($j = 1; $j <= $commentCount; $j++) {
                        $commenter = $projectModel->members()->inRandomOrder()->first();
                        
                        Comment::create([
                            'content' => "This is comment $j on task $i. It provides feedback or additional information about the task.",
                            'user_id' => $commenter->id,
                            'task_id' => $task->id,
                        ]);
                    }
                }
            }
            
            // Add some project comments
            $commentCount = rand(2, 5);
            for ($i = 1; $i <= $commentCount; $i++) {
                $commenter = $projectModel->members()->wherePivot('role', '!=', 'pending')->inRandomOrder()->first();
                
                Comment::create([
                    'content' => "This is project comment $i. It provides general feedback or information about the project.",
                    'user_id' => $commenter->id,
                    'project_id' => $projectModel->id,
                ]);
            }
            
            // Add some project messages
            $messageCount = rand(3, 8);
            for ($i = 1; $i <= $messageCount; $i++) {
                $sender = $projectModel->members()->wherePivot('role', '!=', 'pending')->inRandomOrder()->first();
                
                Message::create([
                    'content' => "This is message $i in the project chat. Team members use this chat to communicate and coordinate.",
                    'sender_id' => $sender->id,
                    'project_id' => $projectModel->id,
                    'created_at' => now()->subHours(rand(1, 72)),
                ]);
            }
        }

        // Add the admin to all projects for testing
        foreach ($projectModels as $project) {
            if ($project->creator_id !== $admin->id && !$project->members->contains($admin->id)) {
                $project->members()->attach($admin->id, ['role' => 'member']);
            }
        }
    }
}
