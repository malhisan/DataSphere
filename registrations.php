<?php

require_once __DIR__ . "/includes/functions.php";

$pageTitle = "Registration List | DataSphere Club";
$activePage = "registrations";

$registrationsFile = __DIR__ . "/data/registrations.csv";
$registrations = [];

if (file_exists($registrationsFile)) {
    $file = fopen($registrationsFile, "r");

    if ($file !== false) {
        $headings = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            if (
                $headings !== false &&
                count($headings) === count($row)
            ) {
                $registrations[] = array_combine(
                    $headings,
                    $row
                );
            }
        }

        fclose($file);
    }
}

require __DIR__ . "/includes/header.php";

?>

<main>
    <section class="page-heading">
        <div class="container">
            <p class="small-title">EVENT REGISTRATIONS</p>

            <h1>Registration List</h1>

            <p>
                The table below displays current registrations for
                upcoming DataSphere events.
            </p>
        </div>
    </section>

    <section class="table-section">
        <div class="container">
            <div class="table-heading">
                <div>
                    <h2>Registered Students</h2>

                    <p>
                        Updated on <?= date("j F Y") ?>
                    </p>
                </div>

                <a class="button" href="register.php">
                    New Registration
                </a>
            </div>

            <div class="table-container">
                <table>
                    <caption>
                        Current event registrations
                    </caption>

                    <thead>
                        <tr>
                            <th scope="col">Number</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Student ID</th>
                            <th scope="col">Event</th>
                            <th scope="col">Study Level</th>
                            <th scope="col">Registration Date</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($registrations)) { ?>

                            <tr>
                                <td colspan="7">
                                    No registrations are currently available.
                                </td>
                            </tr>

                        <?php } else { ?>

                            <?php
                            $number = 1;

                            foreach ($registrations as $registration) {
                            ?>

                                <tr>
                                    <td><?= $number ?></td>

                                    <td>
                                        <?= escape(
                                            $registration["full_name"]
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= escape(
                                            $registration["student_id"]
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= escape(
                                            $registration["event_title"]
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= escape(
                                            $registration["study_level"]
                                        ) ?>
                                    </td>

                                    <td>
                                        <?= escape(
                                            formatEventDate(
                                                $registration[
                                                    "registration_date"
                                                ]
                                            )
                                        ) ?>
                                    </td>

                                    <td>
                                        <span class="status-confirmed">
                                            <?= escape(
                                                $registration["status"]
                                            ) ?>
                                        </span>
                                    </td>
                                </tr>

                            <?php
                                $number++;
                            }
                            ?>

                        <?php } ?>

                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . "/includes/footer.php"; ?>
