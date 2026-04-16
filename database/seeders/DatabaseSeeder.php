<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'laura@admin.com'],
            [
                'name' => 'Laura Marcella Pratama',
                'password' => Hash::make('password123'),
            ]
        );

        // Profile
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Laura Marcella Pratama',
                'bio' => 'Computer Science student at BINUS University (GPA 3.8) focusing on Artificial Intelligence, data analysis, and backend systems. Passionate about turning data into insights and building intelligent systems that solve real-world problems.',
                'linkedin' => 'https://linkedin.com/in/lauramarcella',
                'github' => 'https://github.com/lauramarcella',
            ]
        );

        // Skills — AI
        $aiSkills = ['Machine Learning', 'Deep Learning', 'Data Analysis', 'Data Preprocessing', 'Python for AI', 'AI Problem Solving', 'NLP', 'Computer Vision'];
        foreach ($aiSkills as $skill) {
            Skill::updateOrCreate(['name' => $skill], ['category' => 'AI']);
        }

        // Skills — Web
        $webSkills = ['Laravel', 'PHP', 'JavaScript', 'React', 'HTML/CSS', 'REST API', 'MySQL', 'Tailwind CSS'];
        foreach ($webSkills as $skill) {
            Skill::updateOrCreate(['name' => $skill], ['category' => 'Web']);
        }

        // Skills — Tools
        $toolSkills = ['Git', 'Docker', 'Jupyter Notebook', 'VS Code', 'Figma', 'Postman'];
        foreach ($toolSkills as $skill) {
            Skill::updateOrCreate(['name' => $skill], ['category' => 'Tools']);
        }

        // Projects
        Project::updateOrCreate(
            ['title' => 'AI-Powered Healthcare Diagnosis'],
            [
                'description' => 'An intelligent system that assists medical professionals in diagnosing diseases using patient data and machine learning algorithms.',
                'problem' => 'Manual diagnosis is time-consuming and prone to human error, especially in resource-limited healthcare settings.',
                'approach' => 'Built a classification model using Random Forest and XGBoost on patient symptom data. Applied feature engineering and cross-validation for robust performance.',
                'result' => 'Achieved 94% accuracy in disease prediction across 15 common conditions. Reduced diagnosis time by 60%.',
                'tech_stack' => 'Python, Scikit-learn, Pandas, Flask',
                'github_link' => 'https://github.com/lauramarcella/healthcare-ai',
            ]
        );

        Project::updateOrCreate(
            ['title' => 'Predictive Analytics Dashboard'],
            [
                'description' => 'A comprehensive data analytics platform that visualizes trends and provides predictive insights for business decision-making.',
                'problem' => 'Businesses struggle to extract actionable insights from large datasets without dedicated data science teams.',
                'approach' => 'Developed an interactive dashboard with real-time data processing, time-series forecasting using ARIMA and Prophet models.',
                'result' => 'Enabled 40% faster decision-making for pilot users. Forecasting accuracy within 5% margin of error.',
                'tech_stack' => 'Python, Streamlit, Plotly, Prophet',
                'github_link' => 'https://github.com/lauramarcella/analytics-dashboard',
            ]
        );

        Project::updateOrCreate(
            ['title' => 'Sentiment Analysis Engine'],
            [
                'description' => 'NLP-based system that analyzes social media sentiment in real-time to gauge public opinion on trending topics.',
                'problem' => 'Companies need to monitor brand sentiment across millions of social media posts in real-time.',
                'approach' => 'Implemented BERT-based transformer model fine-tuned on social media data. Built a streaming pipeline for real-time processing.',
                'result' => 'Processes 10,000+ posts/minute with 91% sentiment classification accuracy. Deployed as a REST API.',
                'tech_stack' => 'Python, PyTorch, Transformers, FastAPI',
                'github_link' => 'https://github.com/lauramarcella/sentiment-engine',
            ]
        );

        Project::updateOrCreate(
            ['title' => 'Smart Student Performance Predictor'],
            [
                'description' => 'Machine learning system that predicts student academic performance and identifies at-risk students early.',
                'problem' => 'Universities lack tools to proactively identify students who may struggle academically before it is too late.',
                'approach' => 'Collected and preprocessed multi-dimensional student data. Trained ensemble models with feature importance analysis.',
                'result' => 'Predicted at-risk students with 89% recall. Enabled targeted intervention programs at the university.',
                'tech_stack' => 'Python, Scikit-learn, Pandas, Matplotlib',
                'github_link' => 'https://github.com/lauramarcella/student-predictor',
            ]
        );

        // Experiences
        Experience::updateOrCreate(
            ['title' => 'President of HIMTI'],
            [
                'description' => 'Led the largest IT student organization at BINUS University. Managed 200+ members, organized 15+ events including hackathons, workshops, and tech talks. Developed leadership and project management skills.',
                'role' => 'President',
                'year' => '2025 - 2026',
            ]
        );

        Experience::updateOrCreate(
            ['title' => 'Teaching Assistant — Programming Fundamentals'],
            [
                'description' => 'Assisted professors in teaching C programming and Python to 120+ first-year students. Created supplementary learning materials and conducted weekly lab sessions.',
                'role' => 'Teaching Assistant',
                'year' => '2024 - 2025',
            ]
        );

        Experience::updateOrCreate(
            ['title' => 'Teaching Assistant — Data Structures'],
            [
                'description' => 'Guided students through complex data structure concepts including trees, graphs, and hash tables. Developed practice problems and automated grading scripts.',
                'role' => 'Teaching Assistant',
                'year' => '2025 - 2026',
            ]
        );

        Experience::updateOrCreate(
            ['title' => 'Teaching Assistant — Human-Computer Interaction'],
            [
                'description' => 'Facilitated HCI course labs focusing on UI/UX design principles, usability testing, and user research methodologies.',
                'role' => 'Teaching Assistant',
                'year' => '2025 - 2026',
            ]
        );

        // Achievements
        Achievement::updateOrCreate(
            ['title' => 'SPARC National Data Competition 2026'],
            [
                'description' => 'Winner/Awardee in the prestigious national data science competition. Competed against 500+ teams from universities across Indonesia.',
                'year' => '2026',
            ]
        );

        Achievement::updateOrCreate(
            ['title' => 'Top Finalist — Data Slayer Competition'],
            [
                'description' => 'Reached the final round of the Data Slayer Competition, showcasing advanced data analysis and machine learning skills.',
                'year' => '2025',
            ]
        );

        Achievement::updateOrCreate(
            ['title' => 'AI Healthcare Hackathon Participant'],
            [
                'description' => 'Participated in a 48-hour AI healthcare hackathon, building an intelligent diagnosis assistant that impressed the judging panel.',
                'year' => '2025',
            ]
        );

        Achievement::updateOrCreate(
            ['title' => 'GPA 3.8 Academic Excellence'],
            [
                'description' => 'Maintained a GPA of 3.8/4.0 throughout the Computer Science program at BINUS University while actively participating in organizational activities.',
                'year' => '2024 - Present',
            ]
        );
    }
}
