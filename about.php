<?php 
// Example Team Data - UPDATE THIS ARRAY WITH COMPLETE DETAILS
$team_members = [
    [
        'name' => 'Siyabonga Mkhize',
        'student_no' => '22430686',
        'picture' => 'Siyabonga.jpg',
        'role' => 'Lead Frontend Developer (Coder)',
        'description' => 'Responsible for the mobile-first CSS framework and client-side interactions.'
    ],
    [
        'name' => 'Isaac Toluwanimi Olatunji',
        'student_no' => '22461594',
        'picture' => 'Isaac.jpg',
        'role' => 'Project Lead & Coder',
        'description' => 'Managed team coordination, coded core logic, and ensured final product delivery.'
    ],
    [
        'name' => 'Siyamthanda Dlamini',
        'student_no' => '22435296',
        'picture' => 'Siyamthanda.png',
        'role' => 'Documentation Writer (Documenter)',
        'description' => 'Authored the project documentation, user manuals, and technical reports.'
    ],
    [
        'name' => 'Owethu Tyra Ngubane',
        'student_no' => '22149813',
        'picture' => 'Owethu.jpg',
        'role' => 'Backend Coder & Database Specialist',
        'description' => 'Handled server-side logic, database queries, and security protocols.'
    ],
    [
        'name' => 'Kwazi Dikoko',
        'student_no' => '22494121',
        'picture' => 'Kwazi.jpg',
        'role' => 'Code Reviewer & Quality Assurance',
        'description' => 'Ensured code quality, conducted testing, and managed version control.'
    ],
    [
        'name' => 'Liyema Zama',
        'student_no' => '22452585',
        'picture' => 'Liyema.jpg',
        'role' => 'Interface Design & UI/UX (Coder)',
        'description' => 'Designed the app layout and user experience flow for all pages.'
    ],
    [
        'name' => 'Ayanda Mthembu',
        'student_no' => '22406394',
        'picture' => 'Ayanda.jpg',
        'role' => 'Technical Writer & Editor (Documenter)',
        'description' => 'Edited technical documentation for clarity and precision.'
    ],
    [
        'name' => 'Adam Mohamed',
        'student_no' => '22379592',
        'picture' => 'Adam.jpg',
        'role' => 'Research & Development',
        'description' => 'Conducted initial project research and technical feasibility studies.'
    ],
    [
        'name' => 'S.S Mwandla',
        'student_no' => '22494245',
        'picture' => 'S.S Mwandla.jpg',
        'role' => 'Presentation & Communication',
        'description' => 'Prepared and presented project milestones to stakeholders.'
    ],
    [
        'name' => 'Thulani Knowledge Thabethe',
        'student_no' => '21628190',
        'picture' => 'Thabethe.jpg',
        'role' => 'Backend Coder & Maintenance',
        'description' => 'Assisted with backend development and system maintenance tasks.'
    ]
];

// Shuffle the team members array to randomize card positions
shuffle($team_members);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Team</title>
    <link rel="stylesheet" href="ASSETS/css/about.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="Assets/CSS/style.css"> 
    <style>
        .message {
            text-align: center;
            font-size: 18px;
            margin: 20px 0;
            color: red;
        }
    </style>
</head>
<body>
    <div class="page-wrapper">
        <div class="app-container">
            <header class="main-header">
                <a href="index.php" class="logo-link"><span class="logo">WOOLWORTHS</span></a>
                <div class="header-icons">
                    <a href="<?php echo $isLoggedIn ? 'profile.php' : 'login.php'; ?>" class="icon-link"><i class="fa-regular fa-user"></i></a>
                    <a href="cart.php" class="icon-link shopping-cart">
                        <i class="fa-solid fa-cart-shopping"></i>
                        <span class="cart-count">3</span>
                    </a>
                    <button id="openMenuBtn" class="menu-btn"><i class="fa-solid fa-bars"></i></button>
                </div>
            </header>

            <div class="message">
                <p>Please click on a member to view their certificate.</p>
                <p>Tip: Refresh the page to shuffle the team members' positions.</p>
            </div>
            <div class="title">
                <h2>Our Team</h2>
            </div>

            <div class="card_container"> 
                <?php $counter = 1; ?>
                <?php foreach ($team_members as $member): ?>
                    <div class="card">
                        <a href="certificate.php?name=<?php echo urlencode($member['name']); ?>&certificate=<?php echo urlencode($member['student_no'] . '.pdf'); ?>">
                            <div class="imbBx">
                                <img src="./Pictures/<?php echo $member['picture']; ?>" alt="<?php echo $member['name']; ?>">
                            </div>

                            <div class="content">
                                <!-- Update card content to display only student number and full name -->
                                <div class="contentBx">
                                    <h3>
                                        <?php echo $counter . '. ' . $member['student_no'] . ' - ' . $member['name']; ?>
                                    </h3>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php $counter++; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>