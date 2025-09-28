<?php 
// Example Team Data - UPDATE THIS ARRAY WITH COMPLETE DETAILS
$team_members = [
    [
        'name' => 'Isaac Toluwanimi Olatunji',
        'student_no' => '22461594',
        'picture' => 'Isaac.jpg',
        'role' => 'Project Lead & Coder',
        'description' => 'Managed team coordination, coded core logic, and ensured final product delivery.'
    ],
    [
        'name' => 'Siyabonga Mkhize',
        'student_no' => '22430686',
        'picture' => 'Siyabonga.jpg',
        'role' => 'Lead Frontend Developer (Coder)',
        'description' => 'Responsible for the mobile-first CSS framework and client-side interactions.'
    ],
    [
        'name' => 'Siyamthanda Dlamini',
        'student_no' => '22435296',
        'picture' => 'Siyamthanda.jpg',
        'role' => 'Documentation Writer (Documenter)',
        'description' => 'Authored the project documentation, user manuals, and technical reports.'
    ],
    [
        'name' => 'Bongumusa Zuma',
        'student_no' => '22201607',
        'picture' => 'Bongumusa.jpg',
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
?>

<body>
    <div class="wrapper">
        <div class="title">
            <h2>Our Team</h2>
        </div>

        <div class="card_container"> 
            
            <?php $counter = 1; ?>
            <?php foreach ($team_members as $member): ?>
                
                <div class="card">
                    <div class="imbBx">
                        <img src="./Pictures/<?php echo $member['picture']; ?>" alt="<?php echo $member['name']; ?>">
                    </div>

                    <div class="content">
                        <div class="contentBx">
                            <h3>
                                <?php echo $counter . '. ' . $member['name']; ?> <br>
                                <span><?php echo $member['student_no']; ?></span>
                            </h3>
                        </div>
                        
                        <p class="member-role"><?php echo $member['role']; ?></p>
                        
                        <p class="member-description"><?php echo $member['description']; ?></p>
                    </div>
                </div>
                
                <?php $counter++; ?>
            <?php endforeach; ?>
            
        </div>
        
        <footer>
            <p>© 2025 Woolworths. All Rights Reserved.</p>
        </footer>
    </div>
</body>