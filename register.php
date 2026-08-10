<?php

require_once __DIR__ . "/includes/functions.php";

$pageTitle = "Register | DataSphere Club";
$activePage = "register";

$eventsFile = __DIR__ . "/data/events.csv";
$registrationsFile = __DIR__ . "/data/registrations.csv";

$events = loadEvents($eventsFile);

$fullName = "";
$studentId = "";
$email = "";
$phone = "";
$eventId = isset($_GET["event_id"])
    ? trim($_GET["event_id"])
    : "";
$studyLevel = "";
$notes = "";
$confirmation = false;

$errors = [];
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fullName = trim($_POST["full_name"] ?? "");
    $studentId = trim($_POST["student_id"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $eventId = trim($_POST["event_id"] ?? "");
    $studyLevel = trim($_POST["study_level"] ?? "");
    $notes = trim($_POST["notes"] ?? "");
    $confirmation = isset($_POST["confirmation"]);

    if (mb_strlen($fullName) < 3) {
        $errors[] = "Full name must contain at least 3 characters.";
    }

    if (!preg_match("/^[0-9]{8,10}$/", $studentId)) {
        $errors[] = "Student ID must contain 8 to 10 numbers.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    if ($phone !== "" && !preg_match("/^[0-9]{10}$/", $phone)) {
        $errors[] = "Phone number must contain 10 numbers.";
    }

    $selectedEventTitle = "";
    $eventExists = false;

    foreach ($events as $event) {
        if ($event["id"] === $eventId) {
            $selectedEventTitle = $event["title"];
            $eventExists = true;
            break;
        }
    }

    if (!$eventExists) {
        $errors[] = "Select a valid event.";
    }

    $validLevels = ["1", "2", "3", "4", "5", "6", "7", "8"];

    if (!in_array($studyLevel, $validLevels, true)) {
        $errors[] = "Select a valid study level.";
    }

    if (mb_strlen($notes) > 500) {
        $errors[] = "Additional notes must not exceed 500 characters.";
    }

    if (!$confirmation) {
        $errors[] = "You must confirm that the information is correct.";
    }

    if (empty($errors) && file_exists($registrationsFile)) {
        $file = fopen($registrationsFile, "r");

        if ($file !== false) {
            $headings = fgetcsv($file);

            while (($row = fgetcsv($file)) !== false) {
                if (
                    $headings !== false &&
                    count($headings) === count($row)
                ) {
                    $registration = array_combine($headings, $row);

                    if (
                        $registration["student_id"] === $studentId &&
                        $registration["event_id"] === $eventId
                    ) {
                        $errors[] =
                            "You are already registered for this event.";
                        break;
                    }
                }
            }

            fclose($file);
        }
    }

    if (empty($errors)) {
        $fileIsEmpty =
            !file_exists($registrationsFile) ||
            filesize($registrationsFile) === 0;

        $$file = fopen($registrationsFile, "a");

if ($file === false) {
    $errors[] = "The registration could not be saved.";
} else {
    flock($file, LOCK_EX);
            if ($fileIsEmpty) {
                fputcsv($file, [
                    "full_name",
                    "student_id",
                    "email",
                    "phone",
                    "event_id",
                    "event_title",
                    "study_level",
                    "notes",
                    "registration_date",
                    "status"
                ]);
            
            }

            fputcsv($file, [
                $fullName,
                $studentId,
                $email,
                $phone,
                $eventId,
                $selectedEventTitle,
                $studyLevel,
                $notes,
                date("Y-m-d"),
                "Confirmed"
            ]);
            fflush($file);
            flock($file, LOCK_UN);
            fclose($file);



            $successMessage =
                "Your registration has been confirmed successfully.";

            $fullName = "";
            $studentId = "";
            $email = "";
            $phone = "";
            $eventId = "";
            $studyLevel = "";
            $notes = "";
            $confirmation = false;
        }
    }
}

require __DIR__ . "/includes/header.php";

?>

<main>
    <section class="page-heading">
        <div class="container">
            <p class="small-title">EVENT REGISTRATION</p>

            <h1>Register for an Event</h1>

            <p>
                Complete the form below to request a place in one of
                the upcoming DataSphere events.
            </p>
        </div>
    </section>

    <section class="form-section">
        <div class="container">

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
                class="registration-form"
                action="register.php"
                method="post"
            >
                <h2>Student Information</h2>

                <p class="form-description">
                    All fields marked with an asterisk (*) are required.
                </p>

                <div class="form-row">
                    <div class="form-group">
                        <label for="full-name">Full Name *</label>

                        <input
                            type="text"
                            id="full-name"
                            name="full_name"
                            value="<?= escape($fullName) ?>"
                            placeholder="Enter your full name"
                            minlength="3"
                            maxlength="100"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="student-id">Student ID *</label>

                        <input
                            type="text"
                            id="student-id"
                            name="student_id"
                            value="<?= escape($studentId) ?>"
                            placeholder="Enter your student ID"
                            pattern="[0-9]{8,10}"
                            title="Student ID must contain 8 to 10 numbers"
                            required
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">University Email *</label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?= escape($email) ?>"
                            placeholder="student@seu.edu.sa"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>

                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            value="<?= escape($phone) ?>"
                            placeholder="05XXXXXXXX"
                            pattern="[0-9]{10}"
                            title="Phone number must contain 10 numbers"
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="event">Select Event *</label>

                        <select id="event" name="event_id" required>
                            <option value="">Choose an event</option>

                            <?php foreach ($events as $event) { ?>

                                <option
                                    value="<?= escape($event["id"]) ?>"
                                    <?php
                                    if ($eventId === $event["id"]) {
                                        echo "selected";
                                    }
                                    ?>
                                >
                                    <?= escape($event["title"]) ?>
                                </option>

                            <?php } ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="study-level">Study Level *</label>

                        <select
                            id="study-level"
                            name="study_level"
                            required
                        >
                            <option value="">Choose your level</option>

                            <?php for ($level = 1; $level <= 8; $level++) { ?>

                                <option
                                    value="<?= $level ?>"
                                    <?php
                                    if ($studyLevel === (string) $level) {
                                        echo "selected";
                                    }
                                    ?>
                                >
                                    Level <?= $level ?>
                                </option>

                            <?php } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Additional Notes</label>

                    <textarea
                        id="notes"
                        name="notes"
                        rows="5"
                        maxlength="500"
                        placeholder="Enter any relevant notes"
                    ><?= escape($notes) ?></textarea>
                </div>

                <div class="checkbox-group">
                    <input
                        type="checkbox"
                        id="confirmation"
                        name="confirmation"
                        <?php
                        if ($confirmation) {
                            echo "checked";
                        }
                        ?>
                        required
                    >

                    <label for="confirmation">
                        I confirm that the information entered is correct.
                    </label>
                </div>

                <div class="form-buttons">
                    <button class="button" type="submit">
                        Submit Registration
                    </button>

                    <button
                        class="button reset-button"
                        type="reset"
                    >
                        Clear Form
                    </button>
                </div>
            </form>
        </div>
    </section>
</main>

<?php require __DIR__ . "/includes/footer.php"; ?>
