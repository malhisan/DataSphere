<?php

require_once __DIR__ . "/includes/functions.php";

$eventsFile = __DIR__ . "/data/events.csv";
$events = loadEvents($eventsFile);

$eventId = isset($_GET["id"]) ? $_GET["id"] : "";
$selectedEvent = null;

foreach ($events as $event) {
    if ($event["id"] === $eventId) {
        $selectedEvent = $event;
        break;
    }
}

$activePage = "events";

if ($selectedEvent === null) {
    $pageTitle = "Event Not Found | DataSphere Club";
    http_response_code(404);
} else {
    $pageTitle = $selectedEvent["title"] . " | DataSphere Club";
}

require __DIR__ . "/includes/header.php";

?>

<main>

    <?php if ($selectedEvent === null) { ?>

        <section class="page-heading">
            <div class="container">
                <p class="small-title">EVENT DETAILS</p>

                <h1>Event Not Found</h1>

                <p>
                    The requested event does not exist or the event ID
                    is missing.
                </p>

                <a class="button" href="events.php">
                    Back to Events
                </a>
            </div>
        </section>

    <?php } else { ?>

        <section class="page-heading">
            <div class="container">
                <p class="small-title">
                    <?= escape(
                        strtoupper($selectedEvent["category"])
                    ) ?> DETAILS
                </p>

                <h1>
                    <?= escape($selectedEvent["title"]) ?>
                </h1>

                <p>
                    <?= escape($selectedEvent["short_description"]) ?>
                </p>
            </div>
        </section>

        <section class="event-details-section">
            <div class="container event-details-layout">

                <article class="event-main-content">
                    <img
                        class="details-event-photo"
                        src="assets/<?= escape($selectedEvent["image"]) ?>"
                        alt="<?= escape($selectedEvent["image_alt"]) ?>">

                    <h2>About This Event</h2>

                    <p>
                        <?= escape($selectedEvent["full_description"]) ?>
                    </p>

                    <h2>Who Can Attend?</h2>

                    <p>
                        This event is open to university students interested
                        in data science, artificial intelligence, and related
                        technical topics.
                    </p>

                    <h2>Before You Attend</h2>

                    <p>
                        Complete the registration form before attending.
                        Additional instructions will be provided by the club
                        when necessary.
                    </p>
                </article>

                <aside class="event-summary">
                    <h2>Event Information</h2>

                    <div class="information-item">
                        <p class="information-label">Date</p>

                        <p>
                            <?= escape(
                                formatEventDate(
                                    $selectedEvent["date"]
                                )
                            ) ?>
                        </p>
                    </div>

                    <div class="information-item">
                        <p class="information-label">Time</p>

                        <p>
                            <?= escape($selectedEvent["time"]) ?>
                        </p>
                    </div>

                    <div class="information-item">
                        <p class="information-label">Location</p>

                        <p>
                            <?= escape($selectedEvent["location"]) ?>
                        </p>
                    </div>

                    <div class="information-item">
                        <p class="information-label">Category</p>

                        <p>
                            <?= escape($selectedEvent["category"]) ?>
                        </p>
                    </div>

                    <div class="information-item">
                        <p class="information-label">Registration</p>
                        <p>Required</p>
                    </div>

                    <a
                        class="button register-button"
                        href="register.php?event_id=<?= rawurlencode(
                            $selectedEvent["id"]
                        ) ?>"
                    >
                        Register for This Event
                    </a>

                    <a class="back-link" href="events.php">
                        Back to Events
                    </a>
                </aside>

            </div>
        </section>

    <?php } ?>

</main>

<?php require __DIR__ . "/includes/footer.php"; ?>
