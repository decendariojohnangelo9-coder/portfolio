<?php
// Add or edit projects here. Order = easiest to hardest.
// 'slug'   : used in the page link (project.php?slug=...). Lowercase, no spaces.
// 'desc'   : short text shown on the project card.
// 'explanation' : list of paragraphs shown on the project page.
// 'live' / 'github' : replace '#' with your real links. Use 'private' for 'github' when the repo is
//                      private: the page then shows a "Request source code" button.
// 'features' (list) and 'gallery' (file, title, caption) are optional.
// 'file' / 'code' : file name and the important snippet(s) shown in the popup.
// 'code_note' : a sentence, or a list of sentences, explaining the snippet(s).
return [

    [
        'slug' => 'life-on-quiz', 'level' => 1,
        'title' => 'LIFE ON Quiz',
        'desc'  => 'An Android quiz app with an animated splash screen, ten multiple-choice questions, and a final score with a message based on how well you did.',
        'explanation' => [
            'LIFE ON Quiz is an Android app built in Android Studio with Java. It tests general knowledge with ten multiple-choice questions, each with four choices (A to D), such as which planet is the largest or how many colors are in a rainbow.',
            'The app opens with an animated LIFE ON logo as the splash screen, then a welcome screen with a Start Quiz button. While playing, the header shows the current question number and a progress bar. At the end, the result screen shows the score out of 10 with one of three messages depending on how high the score is, and the player can choose Play Again or Exit.',
        ],
        'features' => [
            'Animated splash screen with the LIFE ON logo',
            'Welcome screen with a Start Quiz button',
            'Ten multiple-choice questions with four options each (A to D)',
            'Question counter ("Question 1 of 10") and a progress bar',
            'Next button to move to the following question',
            'Result screen showing the final score out of 10',
            'Three different result messages depending on the score',
            'Play Again and Exit buttons',
        ],
        // Phone screenshots and the splash video are in assets/images/projects/life-on-quiz/
        'gallery_portrait' => true,
        'gallery' => [
            ['video' => 'splash.mp4', 'poster' => 'splash-poster.jpg', 'title' => 'Splash screen animation', 'caption' => 'The animated LIFE ON logo that plays when the app opens, followed by the welcome screen.'],
            ['file' => 'welcome.jpg', 'title' => 'Welcome screen', 'caption' => 'The first screen after the splash, with a Start Quiz button.'],
            ['file' => 'question-1.jpg', 'title' => 'Question screen', 'caption' => 'One question at a time with four choices. The header shows the question number and a progress bar.'],
            ['file' => 'question-2.jpg', 'title' => 'Selecting an answer', 'caption' => 'The chosen option is highlighted, then the Next button moves to the following question.'],
            ['file' => 'question-9.jpg', 'title' => 'Near the end', 'caption' => 'Question 9 of 10 with the progress bar almost full.'],
            ['file' => 'result.jpg', 'title' => 'Quiz result', 'caption' => 'The final score out of 10 with a message that depends on the score, and Play Again and Exit buttons.'],
        ],
        'stack' => ['Java', 'Android Studio', 'XML'],
        'live'  => '#', 'github' => '#',
        'hide_links' => true,   // no live demo or GitHub yet: hide both buttons on the project page
        'file'  => 'QuizActivity.java',
        'code'  => <<<'CODE'
// 1. Splash screen: play the logo animation, then open the welcome screen (SplashActivity)
logo.startAnimation(AnimationUtils.loadAnimation(this, R.anim.logo_animation));
new Handler(Looper.getMainLooper()).postDelayed(() -> {
    startActivity(new Intent(this, WelcomeActivity.class));
    finish();
}, 3000);

// 2. Show the current question and update the progress (showQuestion)
private void showQuestion() {
    Question q = questions.get(currentIndex);
    tvProgress.setText("Question " + (currentIndex + 1) + " of " + questions.size());
    progressBar.setProgress(currentIndex + 1);
    tvQuestion.setText(q.getText());
    for (int i = 0; i < optionButtons.length; i++) {
        optionButtons[i].setText(q.getOptions()[i]);
    }
    radioGroup.clearCheck();
}

// 3. Next button: check the answer, add to the score, go to the next question or the result
btnNext.setOnClickListener(v -> {
    int checkedId = radioGroup.getCheckedRadioButtonId();
    if (checkedId == -1) {
        Toast.makeText(this, "Please select an answer.", Toast.LENGTH_SHORT).show();
        return;
    }
    int chosen = radioGroup.indexOfChild(findViewById(checkedId));
    if (chosen == questions.get(currentIndex).getCorrectIndex()) {
        score++;
    }
    currentIndex++;
    if (currentIndex < questions.size()) {
        showQuestion();
    } else {
        Intent intent = new Intent(this, ResultActivity.class);
        intent.putExtra("score", score);
        intent.putExtra("total", questions.size());
        startActivity(intent);
        finish();
    }
});

// 4. Result message depends on the score (ResultActivity)
private String getMessage(int score, int total) {
    double percent = (double) score / total;
    if (percent >= 0.8) return "Excellent work! You really know your stuff.";
    if (percent >= 0.5) return "Good job! Keep practicing.";
    return "Nice try! Play again and beat your score.";
}
CODE,
        'code_note' => [
            'Splash screen: starts the logo animation, waits three seconds with a Handler, opens the welcome screen, and calls finish() so the back button does not return to the splash.',
            'Show question: reads the current question from the list, updates the "Question X of 10" text and the progress bar, fills in the four options, and clears the previous selection.',
            'Next button: blocks the click if no answer is selected, compares the chosen option to the correct one to raise the score, then shows the next question. After the tenth question it sends the score and the total to the result screen.',
            'Result message: turns the score into a percentage and returns one of three messages, from high to low.',
        ],
    ],

    [
        'slug' => 'level-up-life', 'level' => 2,
        'title' => 'Level Up Life',
        'desc'  => 'An RPG-inspired productivity web app where completing habits and tasks earns XP, levels, streaks, and achievement badges.',
        'explanation' => [
            'Level Up Life turns daily goals into quests. The user adds habits and tasks, completes them to earn XP, and levels up like a character in a game. It is for people who want a more fun way to stay productive.',
            'The app has eight pages (Home, Dashboard, Habits, Tasks, Achievements, Statistics, Settings, and About) and is built with plain HTML, CSS, and JavaScript. All data is saved in the browser with localStorage, so it works without a server or an account.',
            'The hardest part was the XP system: every habit and task must update the same player data (XP, level, streak, and achievements) from different pages without getting out of sync. I solved it by keeping one player object in localStorage and shared functions in one script that every page uses.',
        ],
        'features' => [
            'Habit tracker with categories, search, and a streak for each habit',
            'Task manager with priority levels and due dates',
            'XP and level system: each level needs level x 100 XP, with titles from Novice to Legendary',
            'Daily login streak',
            'Achievement badges that unlock as you reach milestones',
            'Dashboard with a daily summary and quick actions',
            'Statistics page with task breakdown, completion rates, and level milestones',
            'Settings for dark or light mode, animations, notifications, player name, and resetting data',
            'Toast notifications and confirmation pop-ups',
            'Responsive layout with a mobile menu',
        ],
        // Gallery images go in assets/images/projects/level-up-life/ . Missing files show a 'coming soon' box.
        'gallery' => [
            ['file' => 'home.jpg', 'title' => 'Home page', 'caption' => 'The landing page with the main call to action and a preview of the XP, streak, and achievement cards.'],
            ['file' => 'dashboard.jpg', 'title' => 'Dashboard', 'caption' => 'The player level and XP bar, a summary of tasks, habits, streak, and achievements, and today\'s habits and tasks.'],
            ['file' => 'habits.jpg', 'title' => 'Habit tracker', 'caption' => 'Add habits with a category, complete them to earn 20 XP, and track the streak of each habit.'],
            ['file' => 'tasks.jpg', 'title' => 'Task manager', 'caption' => 'Add tasks with a priority and due date. Completing a task earns 10 XP.'],
            ['file' => 'achievements.jpg', 'title' => 'Achievements', 'caption' => 'Badges that unlock when the player reaches milestones such as completing tasks, keeping a streak, or reaching a level.'],
            ['file' => 'statistics.jpg', 'title' => 'Statistics', 'caption' => 'Task breakdown by priority, habit progress, completion rates, and level milestones.'],
        ],
        'stack' => ['HTML', 'CSS', 'JavaScript', 'localStorage'],
        'live'  => 'https://level-up-life-silk.vercel.app', 'github' => 'private',
        'file'  => 'js/script.js',
        'code'  => <<<'CODE'
// 1. One player object holds everything (getPlayerData / savePlayerData)
function getPlayerData() {
  return JSON.parse(localStorage.getItem('lul_player') || JSON.stringify({
    xp: 0, level: 1, totalTasks: 0, totalHabits: 0,
    streak: 0, lastLogin: null, achievementsUnlocked: []
  }));
}

// 2. Add XP and level up (addXP)
function xpForLevel(level) { return level * 100; }

function addXP(amount, reason) {
  const data = getPlayerData();
  data.xp += amount;

  const needed = xpForLevel(data.level);
  if (data.xp >= needed) {
    data.xp -= needed;          // carry the extra XP to the next level
    data.level += 1;
    showToast(`LEVEL UP! You are now Level ${data.level}!`, 'xp');
    checkAchievements(data);
  }

  savePlayerData(data);
  updateXPBar();
  showToast(`+${amount} XP - ${reason}`, 'xp');
}

// 3. Daily streak (updateStreak)
function updateStreak() {
  const data = getPlayerData();
  const today = new Date().toDateString();
  if (data.lastLogin !== today) {
    const yesterday = new Date(Date.now() - 86400000).toDateString();
    data.streak = (data.lastLogin === yesterday) ? data.streak + 1 : 1;
    data.lastLogin = today;
    savePlayerData(data);
  }
}

// 4. Achievements are a list of rules, checked against the player data
const ACHIEVEMENTS = [
  { id: 'first_task', name: 'First Step', condition: d => d.totalTasks >= 1 },
  { id: 'streak7',    name: 'Warrior',    condition: d => d.streak >= 7 },
  { id: 'level5',     name: 'Rising Star', condition: d => d.level >= 5 },
];

function checkAchievements(data) {
  ACHIEVEMENTS.forEach(ach => {
    if (!data.achievementsUnlocked.includes(ach.id) && ach.condition(data)) {
      data.achievementsUnlocked.push(ach.id);
      showToast(`Achievement Unlocked: ${ach.name}!`, 'xp');
    }
  });
  savePlayerData(data);
}

// 5. Completing a task (tasks.html)
function completeTask(id) {
  const tasks = getTasks();
  const t = tasks.find(x => x.id === id);
  if (!t || t.done) { showToast('Already completed!', 'warning'); return; }
  t.done = true;
  saveTasks(tasks);

  const data = getPlayerData();
  data.totalTasks = (data.totalTasks || 0) + 1;
  savePlayerData(data);
  checkAchievements(data);

  addXP(10, 'Task completed!');
  renderTasks();
}
CODE,
        'code_note' => [
            'Player data: one object in localStorage keeps the XP, level, streak, totals, and unlocked achievements, so every page reads and writes the same data.',
            'Add XP: adds the XP, and when it reaches the amount needed for the level (level x 100) it subtracts that amount, raises the level, and keeps the extra XP.',
            'Streak: compares the last login with today and yesterday. Logging in on consecutive days adds one, and missing a day resets it to 1.',
            'Achievements: each badge is a rule (a function), and checkAchievements unlocks the ones that are now true and not yet saved.',
            'Complete task: marks the task done, updates the totals, checks the achievements, then gives 10 XP. Habits work the same way and give 20 XP.',
        ],
    ],

    
[
    'slug' => 'carsell',
    'level' => 3,
    'title' => 'CarSell',

    'desc' => 'A web-based car dealership platform where users can explore brand-new vehicles, browse automotive brands, and filter available cars based on their preferences.',

    'explanation' => [
        'CarSell is a web-based car dealership platform designed to showcase brand-new vehicles from different automotive manufacturers. It provides users with a convenient way to explore available cars, browse different brands, and discover vehicle options that match their preferences.',

        'The platform features a vehicle catalog where users can view car images, names, prices, model years, colors, and vehicle types. It also provides search and filtering options, allowing users to find specific makes or models and narrow down their choices based on brand, color, year, and vehicle type.',

        'CarSell has three types of users. Guests (buyers) can only browse: they see the brands and the vehicle catalog and use the search and filters. Employees update the stock of each car and mark which vehicles are available. Admins can do everything an employee can, plus add, edit, and delete vehicles and manage accounts.',

        'Vehicle, stock, and account data are saved in an SQL database. Each action checks the logged-in user\'s role first, so a guest cannot change stock and an employee cannot manage accounts.'
    ],

    'features' => [
        'Homepage with platform introduction and navigation',
        'Display of 10 automotive brands',
        'Vehicle catalog with images and pricing',
        'Search vehicles by make or model',
        'Filter vehicles by brand, color, year, and type, and sort the results',
        'Vehicle information including model year, color, and price',
        'Individual vehicle details page access',
        'Three user roles: Guest (buyer view), Employee, and Admin',
        'Employees update car stock and availability',
        'Admins have full control over vehicles and accounts',
        'Login and registration with email and password'
    ],

    // Gallery images go in assets/images/projects/carsell/
    'gallery' => [
        ['file' => 'home.jpg', 'title' => 'Home page', 'caption' => 'The landing page with the hero section, the Browse Vehicles button, and the Guest visitor badge.'],
        ['file' => 'brands.jpg', 'title' => 'Automotive brands', 'caption' => 'Ten brands (Toyota, Mazda, Hyundai, Kia, Nissan, Honda, Ford, Mitsubishi, Suzuki, Isuzu) that a buyer can select to see that brand\'s inventory.'],
        ['file' => 'catalog.jpg', 'title' => 'Vehicle catalog', 'caption' => 'Search by make or model, sort, and filter by brand, color, year, and type. Each card shows the price, year, color, and type.'],
        ['file' => 'login.jpg', 'title' => 'Login', 'caption' => 'Sign in with email and password. Employees and admins log in here; guests can browse without an account.'],
    ],

    'stack' => ['HTML', 'CSS', 'JavaScript', 'SQL'],

    'live' => 'https://carsell-seven.vercel.app',
    'github' => 'private',
    'file'  => 'catalog.js',
    'code'  => <<<'CODE'
// 1. Search, filter, and sort the catalog (applyFilters)
function applyFilters(vehicles, f){
  const q = f.search.trim().toLowerCase();
  const result = vehicles.filter(v =>
    (!q || `${v.make} ${v.model}`.toLowerCase().includes(q)) &&
    (f.brand === 'all' || v.make === f.brand) &&
    (f.color === 'all' || v.color === f.color) &&
    (f.year  === 'all' || v.year === Number(f.year)) &&
    (f.type  === 'all' || v.type === f.type)
  );
  if(f.sort === 'price-asc')  result.sort((a, b) => a.price - b.price);
  if(f.sort === 'price-desc') result.sort((a, b) => b.price - a.price);
  return result;
}

// 2. Role permissions: what each type of user may do
const PERMISSIONS = {
  guest:    ['view'],
  employee: ['view', 'update_stock', 'set_availability'],
  admin:    ['view', 'update_stock', 'set_availability',
             'add_vehicle', 'edit_vehicle', 'delete_vehicle', 'manage_users'],
};
function can(role, action){
  return (PERMISSIONS[role] || PERMISSIONS.guest).includes(action);
}

// 3. Update stock (employee and admin only)
async function updateStock(user, vehicleId, qty){
  if(!can(user.role, 'update_stock')) return showToast('Access denied.', false);
  if(!Number.isInteger(qty) || qty < 0) return showToast('Enter a valid quantity.', false);
  await db.updateVehicle(vehicleId, { stock: qty, available: qty > 0 });
  showToast('Stock updated.', true);
}
CODE,
    'code_note' => [
        'Search and filter: lowercases the search text and checks it against the make and model, then keeps only the cars that match the chosen brand, color, year, and type. "All" means that filter is skipped.',
        'Sort: orders the filtered cars by price, lowest or highest first.',
        'Roles: one table lists what a guest, an employee, and an admin may do, and can() checks it before any action runs.',
        'Update stock: only employees and admins can run it. It validates the quantity, saves the new stock, and marks the car as unavailable when the stock reaches zero.',
    ],
],

    [
        'slug' => 'fitforge', 'level' => 4,
        'title' => 'FitForge',
        'desc'  => 'A fitness platform with structured workout programs, video tutorials, and a progress tracker, with user accounts.',
        'explanation' => [
            'FitForge is a web-based fitness and workout tutorial system. It helps beginners and regular gym-goers follow a structured training plan instead of guessing what to do each day. Users create an account, pick a program that matches their level, and follow the weekly schedule.',
            'Every session can be logged with the exercises done, duration, calories, and notes. The tracker shows weekly progress and workout history, lets users skip a day, and automatically records missed workout days so the history stays accurate.',
            'The Home page also has a library of exercise video tutorials grouped by category, with a search bar, so users can learn the correct form before they train.',
            'The site is a single page built with plain HTML, CSS, and JavaScript and hosted on Vercel. Supabase handles sign up, login, and the database (profiles, workout logs, and the video list), while Cloudinary stores and streams the tutorial videos.',
        ],
        'features' => [
            'Account system with sign up, login, and profile management',
            'Six training programs that can be filtered by level (Beginner, Intermediate, Advanced, All Levels)',
            'Weekly schedule and workout details for each program',
            'Enroll in one program at a time',
            'Workout tracker with exercises, duration, calories, and notes',
            'Weekly progress and session history, with edit and delete',
            'Skip-day marking and automatic missed-day detection',
            'Searchable video tutorials grouped by category',
        ],
        // Gallery images go in assets/images/projects/<slug>/ . Missing files show a 'coming soon' box.
        'gallery' => [
            ['file' => 'home.jpg', 'title' => 'Home page', 'caption' => 'The landing page with the hero section and the main call to action.'],
            ['file' => 'videos.jpg', 'title' => 'Video tutorials', 'caption' => 'Exercise videos grouped by category, with a search bar. The videos are stored on Cloudinary.'],
            ['file' => 'login.jpg', 'title' => 'Login and sign up', 'caption' => 'Account creation and login through Supabase Auth, with validation for the password, email, and Terms checkbox.'],
            ['file' => 'programs.jpg', 'title' => 'Programs', 'caption' => 'Six training programs that can be filtered by level, each with a weekly schedule and an Enroll button.'],
            ['file' => 'tracker.jpg', 'title' => 'Workout tracker', 'caption' => 'Log a session with exercises, duration, calories, and notes, then review weekly progress and history.'],
            ['file' => 'account.jpg', 'title' => 'Account', 'caption' => 'Profile and account settings of the logged-in user.'],
        ],
        'stack' => ['HTML', 'CSS', 'JavaScript', 'Supabase', 'Cloudinary'],
        'live'  => 'https://fitforge-virid.vercel.app', 'github' => 'private',
        'file'  => 'index.html',
        'code'  => '// 1. Login (doLogin)
async function doLogin(){
  const email = document.getElementById(\'l-email\').value.trim().toLowerCase();
  const pass  = document.getElementById(\'l-pass\').value;
  if(!email || !pass) return showError(\'loginErr\',\'Please fill in all fields.\');
  const {data, error} = await sb.auth.signInWithPassword({email, password: pass});
  if(error) return showError(\'loginErr\', error.message);
  await loadUserData(data.user);
  closeAuth(); updateNavState(); render();
}

// 2. Sign up validation (doSignup)
if(pass.length < 6) return showError(\'signupErr\',\'Password must be at least 6 characters.\');
if(!/^[^\\s@]+@[^\\s@]+\\.[^\\s@]{2,}$/.test(email)) return showError(\'signupErr\',\'Enter a valid email address.\');
if(!document.getElementById(\'agreeTerms\').checked) return showError(\'signupErr\',\'Please agree to the Terms & Conditions.\');
const {data, error} = await sb.auth.signUp({email, password: pass, options:{data:{name}}});

// 3. One program at a time (enrollProgram)
if(u.enrolledPrograms.includes(currentProgName)) return;   // already in this program
if(u.enrolledPrograms.length >= 1) return;                 // already in a different one
u.enrolledPrograms = [currentProgName];
u.enrolledAt[currentProgName] = Date.now();

// 4. Log a session (submitLog)
const existing = getTodayLog(session.email, prog);
if(existing && editingLogTs === null){
  showToast(\'Already logged today. Click Edit to make changes.\', false);
  return;
}
const completionPct = totalItems ? Math.round((checkedNames.length / totalItems) * 100) : null;

// 5. Missed-day detection (checkAutoFail)
for(let offset = 1; offset <= 7; offset++){
  const d = new Date(now); d.setDate(now.getDate() - offset); d.setHours(12,0,0,0);
  const dIdx = (d.getDay() + 6) % 7;                 // Monday = 0
  if(!wdIdx.includes(dIdx)) continue;                // not a workout day
  const dayStart = new Date(d); dayStart.setHours(0,0,0,0);
  const dayEnd   = new Date(d); dayEnd.setHours(23,59,59,999);
  const hasLog = logs.some(l => l.ts >= dayStart.getTime() && l.ts <= dayEnd.getTime() && l.program === progName);
  if(!hasLog) { /* save a log with mood \'Missed\' and autoFail: true */ }
}',
        'code_note' => [
            'Login: checks the fields, then Supabase Auth verifies the email and password. On success the user\'s data is loaded and the page updates.',
            'Sign up: validates the password length, the email pattern (regex), and the Terms checkbox before creating the account.',
            'Enroll: a user can follow only one program at a time. A second enrollment is blocked, and the enroll date is saved.',
            'Log a session: blocks duplicate logs for the same day and computes the completion percentage from the checked exercises.',
            'Missed days: loops over the past 7 days, finds scheduled workout days with no log, and records them as missed.',
        ],
    ],
];
