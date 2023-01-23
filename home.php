<?php
    session_start();
?>
<!-- Welcome Page -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Rate myUSC Housing</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <link rel="stylesheet" href="config/nav.css">
        <style>
            * { /* Resizing measure for multiple screen sizes */
                box-sizing: border-box;
            }
            html {
                scroll-behavior: smooth;
            }

            body {
                margin: 0;
                padding: 0;
            }

            /* Home page banner implementation */
            .banner-txt {
                width: 24%;
                padding: 1% 2%;
                position: absolute;
                left: 15%;
                top: 18%;
                color: white;
                background: rgba(0, 0, 0, 0.6);
                border-radius: 5px;
                z-index: 9;
            }

            .banner-txt a {
                text-decoration: none;
            }

            .welcome-link {
                width: 100%;
                height: 44px;
                border: 1px solid #ba382c;
                background: #ba382c;
                color: #fff;
                font-size: 16px;
                text-align: center;
                line-height: 44px;
            }

            #banner-image {
                width: 100%;
                height: auto;
                max-height: calc(100vh);
                display: block;
                margin: 0 auto;
                padding: 0;
                object-fit: cover;
                /*
                height: calc(100vh - 100px);
                object-fit: cover;
                */
            }
            /* End of home page banner implementation */

            #main-container {
                width: 100%;
            }

            #content {
                scroll-margin-top: 100px; /* Scroll to slightly above content so it's not cut off by navbar */
            }

            h2 {
                margin-top: 2rem;
            }

            p {
                margin-top: 1rem;
            }

            #main_housing1 {
                width: 450px;
                height: auto;
                float: right;
                margin-left: 20px;
                margin-bottom: 15px;
            }

            #main_apartment {
                width: 450px;
                height: auto;
                float: left;
                margin-right: 20px;
                margin-bottom: 15px;
            }

            #commute {
                width: 450px;
                height: auto;
                float: right;
                margin-left: 20px;
                margin-bottom: 15px;
            }

            @media (max-width: 1055px){
                .banner-txt {
                    width: 75%;
                }
            }
        </style>
    </head>
    <body>
        <?php include 'config/nav.php';?>

        <div class="banner-txt">
            <h1>
                Get the truth on your next home
            </h1>
            <p>
                College housing can quickly become complicated with so many options to choose from. One thing that helps is
                to hear from previous tenants on how they enjoyed living at your potential new home, before you move in.
            </p>
            <a href="#content"><p class="welcome-link">Learn More</p></a>
        </div>
        <div id="img-div">
            <img id="banner-image" src="img/housing_banner.png" alt="Decorational building background">
        </div>
        <div id="main-container" class="container mb-5">
            <section id="content">
                <h2>Our Purpose</h2>
                <img id="main_housing1" class="d-block" src="img/main_housing1.png" alt="Student standing in front of building">
                <p>
                    The search for college housing can be tough and stressful. Even if a location fulfills your personal criteria, there is some info that you can't find online until you
                    either take a tour or move in after signing a lease. If you decide you don't like the location after signing the lease, you are stuck there until the lease ends or if
                    you are able (and allowed) to find someone to take over the lease. As an alternative of all that stress and uncertainty, this site aims to help you see those hidden
                    details on a location, before applying at all. We aim to have real tenants give their perspective of living at a property during their lease term, skipping all the company
                    marketing and going straight to the factors you actually care about.
                </p>
                <p>
                    Our goal is for you to utilize this site to find everything you need to know about a location, so you can be certain on whether or not you should commit to living there. Our review
                    system is designed to be very quick and easy to understand for both reviewers, and searchers.
                </p>
                <h2>Stories From The Creator</h2>
                <img id="main_apartment" class="d-block" src="img/main_apartment.jpg" alt="Empty apartment kitchen">
                <p>
                    As the creator, I had a hard time finding somewhere to live last year since a lot of posts I saw that were affordable, seemed like scams or had very little information. An example
                    is that on Facebook Marketplace, I found a decent deal on an apartment, but the landlord wanted me to quickly sign on it and got angry when I asked for a tour. I still don't know if
                    it was a scam or not, but it was definitely not worth taking the risk.
                </p>
                <p>
                    In another situation, I had toured two properties owned by a company on different days. I was very happy with the first property and after touring the second property, I wanted to move
                    forward with the first property. The company was eager for my application and one representative really wanted me to pay their application fee, but they wouldn't confirm if the apartment was still
                    available. After they kept insisting I pay the fee, I spoke with a different representative and found out that they gave the property away while I was waiting for confirmation (application was aleady
                    submitted but no fee paid yet). When informing the original representative about this, they tried getting me to sign for a different (not very good) property with the promise of moving me to a better
                    property about 2 months later when construction on it is finished. Although companies are allowed to do first-come first-serve based on application fees, I was so angered that they
                    kept insisting me to pay the application fee, but the property wasn't even available yet. This gave me a preview of how the company operates and I knew that living in their units
                    would quickly become annoying or have lackluster support.
                </p>
                <img id="commute" class="d-block" src="img/commute.jpg" alt="Cars in traffic">
                <p>
                    The reason why I have shared these stories is that both situations could be quickly dealt with if I could see real reviews on the property. There are some review sites
                    for apartments and college housing, but nothing specific to USC Student Housing that fulfilled my personal criteria. My housing search at that time was incredibly tiring and exhausting,
                    especially when I wanted to do a tour of the place since I lived over 1 hour away from USC. I got so tired of the process that I just settled with a place after talking to its
                    current tenant, but I only had a virtual tour so I wasn't sure if I would like it. I dread having to do this entire process again next Spring/Summer, but it would be a lot easier
                    with insightful and accurate reviews of my potential new home, which I hope can be provided by this website, for all USC Students.
                </p>
            </section>
        </div>
</html>