<?php

require_once __DIR__ . "/includes/functions.php";

$pageTitle = "Events | DataSphere Club";
$activePage = "events";

$eventsFile = __DIR__ . "/data/events.csv";
$events = loadEvents($eventsFile);

require __DIR__ . "/includes/header.php";

?>

<main>
    <section class="page-heading">
        <div class="container">
            <p class="small-title">EVENT SCHEDULE</p>
            <h1>Upcoming Events</h1>
            <p>
                View the upcoming workshops, seminars, and student
                activities organized by DataSphere Club.
            </p>
        </div>
    </section>
    <section class="events-page">
        <div class="container">
            <?php if (count($events) === 0) { ?>
                <p>No events are currently available.</p>

            <?php } else { ?>
                <div class="all-events">
                    <?php foreach ($events as $event) { ?>
                        <article class="event-card">
                            
                            <img
                                class="event-photo"
                                src="assets/<?= escape($event["image"]) ?>"
                                alt="<?= escape($event["title"]) ?> event">

                            <div class="event-information">
                                <p class="event-category">
                                    <?= escape($event["category"]) ?>
                                </p>

                                <p class="event-date">
                                    <?= escape(
                                        formatEventDate($event["date"])) ?>
                                </p>
                                <h2>
                                    <?= escape($event["title"]) ?>
                                </h2>
                                <p>
                                    <?= escape($event["short_description"]) ?>
                                </p>
                                <p class="event-place">
                                    <?= escape($event["time"]) ?> |
                                    <?= escape($event["location"]) ?>
                                </p>
                                <a href="event-details.php?id=<?= rawurlencode($event["id"]) ?>">
                                    View Details
                                </a>
                            </div>
                        </article>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>
</main>

<?php require __DIR__ . "/includes/footer.php"; ?>
