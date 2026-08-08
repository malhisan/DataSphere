<?php

require_once __DIR__ . "/includes/functions.php";

$pageTitle = "About & Contact | DataSphere Club";
$activePage = "about";

$messagesFile = __DIR__ . "/data/messages.csv";

$contactName = "";
$contactEmail = "";
$contactSubject = "";
$contactMessage = "";

$errors = [];
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $contactName = trim($_POST["contact_name"] ?? "");
    $contactEmail = trim($_POST["contact_email"] ?? "");
    $contactSubject = trim($_POST["contact_subject"] ?? "");
    $contactMessage = trim($_POST["contact_message"] ?? "");

    if (strlen($contactName) < 3) {
        $errors[] = "Full name must contain at least 3 characters.";
    }

    if (!filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    $validSubjects = [
        "event",
        "registration",
        "membership",
        "suggestion",
        "other"
    ];

    if (!in_array($contactSubject, $validSubjects, true)) {
        $errors[] = "Select a valid subject.";
    }

    if (strlen($contactMessage) < 10) {
        $errors[] = "Message must contain at least 10 characters.";
    }

    if (strlen($contactMessage) > 1000) {
        $errors[] = "Message must not exceed 1000 characters.";
    }

    if (empty($errors)) {
        $fileIsEmpty =
            !file_exists($messagesFile) ||
            filesize($messagesFile) === 0;

        $file = fopen($messagesFile, "a");

        if ($file === false) {
            $errors[] = "The message could not be saved.";
        } else {
            if ($fileIsEmpty) {
                fputcsv($file, [
                    "full_name",
                    "email",
                    "subject",
                    "message",
                    "message_date"
                ]);
            }

            fputcsv($file, [
                $contactName,
                $contactEmail,
                $contactSubject,
                $contactMessage,
                date("Y-m-d H:i:s")
            ]);

            fclose($file);

            $successMessage =
                "Your message has been received successfully.";

            $contactName = "";
            $contactEmail = "";
            $contactSubject = "";
            $contactMessage = "";
        }
    }
}

require __DIR__ . "/includes/header.php";

?>

<main>
    <section class="page-heading">
        <div class="container">
            <p class="small-title">CLUB INFORMATION</p>

            <h1>About &amp; Contact</h1>

            <p>
                Information about DataSphere Club and how to contact
                the club team.
            </p>
        </div>
    </section>

    <section class="team-section">
        <div class="container">
            <h2>Team Members</h2>

            <div class="team-members">
                <article class="team-card">
                    <h3>Abdulrahman Althobaiti</h3>
                    <p>S230023169</p>
                    <p>Task: Home page and project integration</p>
                </article>

                <article class="team-card">
                    <h3>Ali Altammam</h3>
                    <p>S240025636</p>
                    <p>Task: Events and event details pages</p>
                </article>

                <article class="team-card">
                    <h3>Bader Alamiri</h3>
                    <p>S210024048</p>
                    <p>Task: Registration and registration list</p>
                </article>

                <article class="team-card">
                    <h3>Mohammed Alhisan</h3>
                    <p>S240027046</p>
                    <p>Task: About page and responsive design</p>
                </article>
            </div>
        </div>
    </section>

    <section class="about-contact-section">
        <div class="container about-contact-layout">

            <div class="about-content">
                <h2>About DataSphere</h2>

                <p>
                    DataSphere is a university student club focused on
                    data science and artificial intelligence.
                </p>

                <p>
                    The club organizes workshops, seminars, and student
                    activities that introduce technical topics and provide
                    opportunities for practical learning.
                </p>

                <h3>Club Activities</h3>

                <ul class="about-list">
                    <li>Programming and data analysis workshops</li>
                    <li>Data visualization sessions</li>
                    <li>Artificial intelligence seminars</li>
                    <li>Student data competitions</li>
                    <li>Career and CV preparation sessions</li>
                </ul>

                <h3>Event Participation</h3>

                <p>
                    Students can view event information on the Events page
                    and submit the registration form. Valid and non-duplicate
                    registrations are recorded and confirmed automatically.
                </p>

                <div class="club-contact-box">
                    <h3>Club Contact Information</h3>

                    <p>
                        <strong>Email:</strong>

                        <a href="mailto:datasphere@seu.edu.sa">
                            datasphere@seu.edu.sa
                        </a>
                    </p>

                    <p>
                        <strong>Location:</strong>
                        Student Activities Center, Room S-108
                    </p>

                    <p>
                        <strong>Office Hours:</strong>
                        Sunday and Tuesday, 12:00 PM – 2:00 PM
                    </p>
                </div>
            </div>

            <div>
                <?php if ($successMessage !== "") { ?>

                    <div class="form-message success-message">
                        <p><?= escape($successMessage) ?></p>
                    </div>

                <?php } ?>

                <?php if (!empty($errors)) { ?>

                    <div class="form-message error-message">
                        <p>Please correct the following:</p>

                        <ul>
                            <?php foreach ($errors as $error) { ?>
                                <li><?= escape($error) ?></li>
                            <?php } ?>
                        </ul>
                    </div>

                <?php } ?>

                <form
                    class="contact-form"
                    action="about.php"
                    method="post"
                >
                    <h2>Contact the Club</h2>

                    <p class="form-description">
                        Complete the form to send a message to the club team.
                    </p>

                    <div class="form-group">
                        <label for="contact-name">Full Name *</label>

                        <input
                            type="text"
                            id="contact-name"
                            name="contact_name"
                            value="<?= escape($contactName) ?>"
                            placeholder="Enter your full name"
                            minlength="3"
                            maxlength="100"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="contact-email">
                            Email Address *
                        </label>

                        <input
                            type="email"
                            id="contact-email"
                            name="contact_email"
                            value="<?= escape($contactEmail) ?>"
                            placeholder="Enter your email address"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="contact-subject">Subject *</label>

                        <select
                            id="contact-subject"
                            name="contact_subject"
                            required
                        >
                            <option value="">Choose a subject</option>

                            <option
                                value="event"
                                <?= $contactSubject === "event"
                                    ? "selected"
                                    : "" ?>
                            >
                                Event Information
                            </option>

                            <option
                                value="registration"
                                <?= $contactSubject === "registration"
                                    ? "selected"
                                    : "" ?>
                            >
                                Registration Question
                            </option>

                            <option
                                value="membership"
                                <?= $contactSubject === "membership"
                                    ? "selected"
                                    : "" ?>
                            >
                                Club Membership
                            </option>

                            <option
                                value="suggestion"
                                <?= $contactSubject === "suggestion"
                                    ? "selected"
                                    : "" ?>
                            >
                                Suggestion
                            </option>

                            <option
                                value="other"
                                <?= $contactSubject === "other"
                                    ? "selected"
                                    : "" ?>
                            >
                                Other
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="contact-message">Message *</label>

                        <textarea
                            id="contact-message"
                            name="contact_message"
                            rows="7"
                            minlength="10"
                            maxlength="1000"
                            placeholder="Enter your message"
                            required
                        ><?= escape($contactMessage) ?></textarea>
                    </div>

                    <button class="button" type="submit">
                        Send Message
                    </button>
                </form>
            </div>

        </div>
    </section>
</main>

<?php require __DIR__ . "/includes/footer.php"; ?>
