<?php

require_once __DIR__ . "/includes/functions.php";

$pageTitle = "Home";
$activePage = "home";

$eventsFile = __DIR__ . "/data/events.csv";

$events = loadEvents($eventsFile);

$upcomingEvents = array_slice($events, 0, 3);

$featuredEvent = null;

if (count($upcomingEvents) > 0) {
    $featuredEvent = $upcomingEvents[0];
}

require __DIR__ . "/includes/header.php";

?>

<main>
    <section class="hero">
        <div class="container hero-content">
            <div class="hero-text">
                <p class="small-title">
                    DATA SCIENCE &amp; AI CLUB
                </p>

                <h1>Campus Events and Activities</h1>

                <p>
                    DataSphere organizes workshops, seminars, and student
                    activities related to data science and artificial
                    intelligence.
                </p>

                <div class="hero-buttons">
                    <a class="button" href="events.php">
                        View Events
                    </a>

                    <a
                        class="button secondary-button"
                        href="register.php">
                        Register for an Event
                    </a>
                </div>
            </div>

            <div class="featured-event">
                <?php if ($featuredEvent !== null) { ?>

                    <p class="event-type">UPCOMING EVENT</p>

                    <h2>
                        <?php echo escape($featuredEvent["title"]); ?>
                    </h2>

                    <p>
                        <?php
                        echo escape(
                            $featuredEvent["short_description"]
                        );
                        ?>
                    </p>

                    <p>
                        <strong>Date:</strong>

                        <?php
                        echo escape(
                            formatEventDate(
                                $featuredEvent["date"]
                            )
                        );
                        ?>
                    </p>

                    <p>
                        <strong>Time:</strong>

                        <?php
                        echo escape($featuredEvent["time"]);
                        ?>
                    </p>

                    <p>
                        <strong>Location:</strong>

                        <?php
                        echo escape($featuredEvent["location"]);
                        ?>
                    </p>

                    <a
                        href="event-details.php?id=<?php
                        echo urlencode($featuredEvent["id"]);
                        ?>">
                        View Details
                    </a>

                <?php } else { ?>

                    <h2>No Upcoming Events</h2>

                    <p>
                        New events will be added soon.
                    </p>

                <?php } ?>
            </div>
        </div>
    </section>

    <section class="events-section">
        <div class="container">
            <div class="section-title">
                <div>
                    <p class="small-title">EVENT SCHEDULE</p>
                    <h2>Upcoming Events</h2>
                </div>

                <a href="events.php">
                    View All Events
                </a>
            </div>

            <div class="event-cards">
                <?php foreach ($upcomingEvents as $event) { ?>

                    <article class="event-card">
                        <img
                            class="event-photo"
                            src="assets/<?php
                            echo escape($event["image"]);
                            ?>"
                            alt="<?php
                            echo escape($event["image_alt"]);
                            ?>">

                        <div class="event-information">
                            <p class="event-date">
                                <?php
                                echo escape(
                                    formatEventDate(
                                        $event["date"]
                                    )
                                );
                                ?>
                            </p>

                            <h3>
                                <?php echo escape($event["title"]); ?>
                            </h3>

                            <p>
                                <?php
                                echo escape(
                                    $event["short_description"]
                                );
                                ?>
                            </p>

                            <a
                                href="event-details.php?id=<?php
                                echo urlencode($event["id"]);
                                ?>">
                                View Details
                            </a>
                        </div>
                    </article>

                <?php } ?>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <h2>About DataSphere</h2>

            <p>
                DataSphere is a university club that provides technical
                activities for students interested in data science and
                artificial intelligence.
            </p>

            <div class="club-features">
                <div class="feature">
                    <h3>Workshops</h3>

                    <p>
                        Practical sessions on programming and data
                        analysis.
                    </p>
                </div>

                <div class="feature">
                    <h3>Seminars</h3>

                    <p>
                        Presentations about current topics in data
                        science and AI.
                    </p>
                </div>

                <div class="feature">
                    <h3>Competitions</h3>

                    <p>
                        Student challenges involving data analysis and
                        modeling.
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . "/includes/footer.php"; ?>
