<?php
// Vérification de l'appareil au tout début
include_once('check_device.php');

// Démarre la session
session_start();

// Check if user is on desktop
$isDesktop = isDesktop();
if (!$isDesktop) {
    // If not on desktop, redirect to mobile message page
    header("Location: mobile_message.php");
    exit;
}

if (isset($_GET['id'])) {
    include '../conn/conn.php';

    include_once('../controller/controller_users.php');
    include_once('../controller/controller_description_users.php');
    include_once('../controller/controller_metier_users.php');
    include_once('../controller/controller_competence_users.php');
    include_once('../controller/controller_formation_users.php');
    include_once('../controller/controller_diplome_users.php');
    include_once('../controller/controller_certificat_users.php');
    include_once('../controller/controller_outil_users.php');
    include_once('../controller/controller_langue_users.php');
    include_once('../controller/controller_projet_users.php');
    include_once('../controller/controller_message1.php');
    include_once('../controller/controller_appel_offre.php');
    include_once('../controller/controller_centre_interet.php');
}

if (isset($_SESSION['users_id'])) {
    include '../conn/conn.php';
    $users_id = $_SESSION['users_id'];

    include_once('../controller/controller_description_users.php');
    include_once('../controller/controller_metier_users.php');
    include_once('../controller/controller_competence_users.php');
    include_once('../controller/controller_formation_users.php');
    include_once('../controller/controller_diplome_users.php');
    include_once('../controller/controller_certificat_users.php');
    include_once('../controller/controller_outil_users.php');
    include_once('../controller/controller_langue_users.php');
    include_once('../controller/controller_projet_users.php');
    include_once('../controller/controller_users.php');
    include_once('../controller/controller_centre_interet.php');
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CV Template</title>
    <style>
        :root {
            --primary-color: #e2bd5a;
            --secondary-color: #464a57;
            --accent-color: #e2bd5a;
            --text-color: #333;
            --bg-color: #fff;
            --border-radius: 8px;
            --timeline-dot-size: 12px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        .cv-container {
            width: 794px;
            min-height: 1123px;
            margin: 20px auto;
            background-color: var(--bg-color);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Header Section */
        .header {
            display: flex;
            justify-content: space-between;
            padding: 20px 40px;
        }

        .personal-info {
            flex: 2;
        }

        .name {
            color: var(--primary-color);
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .surname {
            color: var(--secondary-color);
            font-size: 40px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .contact-info {
            flex: 1;
            text-align: right;
        }

        .contact-item {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .contact-label {
            font-weight: bold;
            margin-bottom: 3px;
        }

        .contact-value {
            color: #666;
            font-size: 14px;
        }

        .contact-icon {
            background-color: var(--primary-color);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 10px;
        }

        .contact-icon img {
            width: 14px;
            height: 14px;
        }

        /* Profile Section */
        .section-profile {
            background-color: var(--secondary-color);
            color: white;
            padding: 20px 40px;
            position: relative;
            display: flex;
            margin-bottom: 20px;
        }

        .section-profile::before {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 200px;
            background-color: var(--primary-color);
            clip-path: polygon(0 0, 100% 0, 90% 100%, 0 100%);
        }

        .section-title {
            position: relative;
            z-index: 1;
            text-transform: uppercase;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .profile-content {
            position: relative;
            z-index: 1;
            flex: 2;
        }

        .profile-photo {
            flex: 1;
            display: flex;
            justify-content: flex-end;
        }

        .profile-photo img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #fff;
        }

        .profile-text {
            font-size: 14px;
            line-height: 1.5;
            z-index: 1;
            position: relative;
        }

        /* Main Content */
        .main-content {
            display: flex;
            padding: 0 20px 20px;
        }

        .left-column {
            flex: 6;
            padding-right: 20px;
        }

        .right-column {
            flex: 4;
            padding-left: 20px;
            border-left: 1px solid #eee;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .section-header h2 {
            font-size: 18px;
            color: var(--secondary-color);
            text-transform: uppercase;
            font-weight: 700;
            position: relative;
        }

        .section-icon {
            margin-left: auto;
        }

        .section-icon img {
            width: 24px;
            height: 24px;
        }

        /* Timeline */
        .timeline {
            position: relative;
        }

        .timeline::before {
            content: "";
            position: absolute;
            top: 0;
            bottom: 0;
            left: 15px;
            width: 2px;
            background-color: #eee;
        }

        .timeline-item {
            padding-left: 50px;
            margin-bottom: 25px;
            position: relative;
        }

        .timeline-dot {
            position: absolute;
            width: var(--timeline-dot-size);
            height: var(--timeline-dot-size);
            border-radius: 50%;
            background-color: var(--primary-color);
            left: 10px;
            top: 0;
            border: 2px solid #fff;
        }

        .timeline-date {
            font-weight: bold;
            margin-bottom: 5px;
            color: #666;
        }

        .timeline-title {
            font-weight: bold;
            color: var(--secondary-color);
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .timeline-company {
            font-style: italic;
            margin-bottom: 10px;
            color: #666;
        }

        .timeline-description {
            font-size: 14px;
            color: #666;
            line-height: 1.4;
        }

        /* Skills Section */
        .skills-item {
            margin-bottom: 10px;
        }

        .skill-name {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 14px;
            color: var(--secondary-color);
        }

        .stars {
            display: flex;
        }

        .star {
            color: var(--primary-color);
            margin-right: 2px;
        }

        .star-empty {
            color: #ddd;
        }

        /* Language Section */
        .languages {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .language-item {
            text-align: center;
            margin: 10px;
        }

        .language-circle {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            border: 2px solid var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            position: relative;
        }

        .language-percent {
            font-weight: bold;
        }

        .language-name {
            font-size: 14px;
            color: var(--secondary-color);
        }
    </style>
</head>

<body>
    <div class="cv-container">
        <!-- Header with name and contact -->
        <div class="header">
            <div class="personal-info">
                <h1 class="name">DICKY</h1>
                <h1 class="surname">PRAYUDA</h1>
            </div>
            <div class="contact-info">
                <div class="contact-item">
                    <div>
                        <div class="contact-label">Phone</div>
                        <div class="contact-value">+ 00 1234 56789</div>
                    </div>
                    <div class="contact-icon">
                        <img src="phone-icon.png" alt="Phone">
                    </div>
                </div>
                <div class="contact-item">
                    <div>
                        <div class="contact-label">Email</div>
                        <div class="contact-value">info@example.com</div>
                    </div>
                    <div class="contact-icon">
                        <img src="email-icon.png" alt="Email">
                    </div>
                </div>
                <div class="contact-item">
                    <div>
                        <div class="contact-label">Location</div>
                        <div class="contact-value">Address here, City, 1234</div>
                    </div>
                    <div class="contact-icon">
                        <img src="location-icon.png" alt="Location">
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile section -->
        <div class="section-profile">
            <div class="profile-content">
                <h2 class="section-title">PROFILE</h2>
                <p class="profile-text">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the
                    industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type
                    and scrambled it to make a type specimen book. It has survived not only five centuries, but also the
                    leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s
                    with the release of Letraset sheets containing Lorem Ipsum passages
                </p>
            </div>
            <div class="profile-photo">
                <img src="profile-photo.jpg" alt="Profile Photo">
            </div>
        </div>

        <!-- Main content -->
        <div class="main-content">
            <!-- Left column - Experience and Education -->
            <div class="left-column">
                <!-- Work Experience -->
                <div class="section">
                    <div class="section-header">
                        <h2>WORK EXPERIENCE</h2>
                        <div class="section-icon">
                            <img src="work-icon.png" alt="Work">
                        </div>
                    </div>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-date">2015-2021</div>
                            <div class="timeline-title">COMPANY NAME</div>
                            <div class="timeline-company">Lorem Ipsum</div>
                            <div class="timeline-job">JOB POSITIONS</div>
                            <div class="timeline-description">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s.
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-date">2015-2021</div>
                            <div class="timeline-title">COMPANY NAME</div>
                            <div class="timeline-company">Lorem Ipsum</div>
                            <div class="timeline-job">JOB POSITIONS</div>
                            <div class="timeline-description">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s.
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-date">2015-2021</div>
                            <div class="timeline-title">COMPANY NAME</div>
                            <div class="timeline-company">Lorem Ipsum</div>
                            <div class="timeline-job">JOB POSITIONS</div>
                            <div class="timeline-description">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Award Section -->
                <div class="section">
                    <div class="section-header">
                        <h2>AWARD</h2>
                        <div class="section-icon">
                            <img src="award-icon.png" alt="Award">
                        </div>
                    </div>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-date">2015-2021</div>
                            <div class="timeline-title">LOREM IPSUM</div>
                            <div class="timeline-company">Lorem Ipsum</div>
                            <div class="timeline-description">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s.
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-date">2015-2021</div>
                            <div class="timeline-title">LOREM IPSUM</div>
                            <div class="timeline-company">Lorem Ipsum</div>
                            <div class="timeline-description">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s.
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-date">2015-2021</div>
                            <div class="timeline-title">LOREM IPSUM</div>
                            <div class="timeline-company">Lorem Ipsum</div>
                            <div class="timeline-description">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right column - Education, Skills, Languages -->
            <div class="right-column">
                <!-- Education -->
                <div class="section">
                    <div class="section-header">
                        <h2>EDUCATION</h2>
                        <div class="section-icon">
                            <img src="education-icon.png" alt="Education">
                        </div>
                    </div>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-date">2020</div>
                            <div class="timeline-title">Enter Your Masters Degree</div>
                            <div class="timeline-company">University Name</div>
                            <div class="timeline-description">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s.
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-date">2020</div>
                            <div class="timeline-title">Enter Your Masters Degree</div>
                            <div class="timeline-company">University Name</div>
                            <div class="timeline-description">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s.
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="timeline-dot"></div>
                            <div class="timeline-date">2020</div>
                            <div class="timeline-title">Enter Your Masters Degree</div>
                            <div class="timeline-company">University Name</div>
                            <div class="timeline-description">
                                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum
                                has been the industry's standard dummy text ever since the 1500s.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Skills Section -->
                <div class="section">
                    <div class="section-header">
                        <h2>SKILLS</h2>
                        <div class="section-icon">
                            <img src="skills-icon.png" alt="Skills">
                        </div>
                    </div>
                    <div class="skills-content">
                        <div class="skills-item">
                            <div class="skill-name">
                                <span>GRAPHIC DESIGN</span>
                                <div class="stars">
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                </div>
                            </div>
                        </div>
                        <div class="skills-item">
                            <div class="skill-name">
                                <span>WEB DESIGN</span>
                                <div class="stars">
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star-empty">★</span>
                                    <span class="star-empty">★</span>
                                </div>
                            </div>
                        </div>
                        <div class="skills-item">
                            <div class="skill-name">
                                <span>DRAWING</span>
                                <div class="stars">
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star-empty">★</span>
                                </div>
                            </div>
                        </div>
                        <div class="skills-item">
                            <div class="skill-name">
                                <span>ANIMATION</span>
                                <div class="stars">
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star-empty">★</span>
                                    <span class="star-empty">★</span>
                                </div>
                            </div>
                        </div>
                        <div class="skills-item">
                            <div class="skill-name">
                                <span>UI DESIGN</span>
                                <div class="stars">
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star-empty">★</span>
                                    <span class="star-empty">★</span>
                                    <span class="star-empty">★</span>
                                </div>
                            </div>
                        </div>
                        <div class="skills-item">
                            <div class="skill-name">
                                <span>UI DESIGN</span>
                                <div class="stars">
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                </div>
                            </div>
                        </div>
                        <div class="skills-item">
                            <div class="skill-name">
                                <span>UI DESIGN</span>
                                <div class="stars">
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star">★</span>
                                    <span class="star-empty">★</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Language Section -->
                <div class="section">
                    <div class="section-header">
                        <h2>LANGUAGE</h2>
                        <div class="section-icon">
                            <img src="language-icon.png" alt="Language">
                        </div>
                    </div>
                    <div class="languages">
                        <div class="language-item">
                            <div class="language-circle">
                                <span class="language-percent">100%</span>
                            </div>
                            <div class="language-name">English</div>
                        </div>
                        <div class="language-item">
                            <div class="language-circle">
                                <span class="language-percent">75%</span>
                            </div>
                            <div class="language-name">German</div>
                        </div>
                        <div class="language-item">
                            <div class="language-circle">
                                <span class="language-percent">50%</span>
                            </div>
                            <div class="language-name">France</div>
                        </div>
                        <div class="language-item">
                            <div class="language-circle">
                                <span class="language-percent">25%</span>
                            </div>
                            <div class="language-name">Italy</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>