<footer class="container-footer">
    <div class="row">
        <div class="main-column">
            <div class="image-wrapper">
                <img src="https://cdn.builder.io/api/v1/image/assets/TEMP/6070826645f8e5586ef1043911cb72b77a0cf4d63975d244c84c69045be33b86?apiKey=cfbeda57ea98489b824f8f843623dee9&"
                    alt="Location" class="location-image" />
                <div class="address">
                    <p>Jalan Raya, Sawah, Ranu Klindungan, Kec. Grati, </p>
                    <p>Pasuruan, Jawa Timur 67184, Indonesia</p>
                </div>
                <div class="social-icons">
                    <div class="social-icon">
                        <i class="fab fa-facebook-square"></i>
                    </div>
                    <div class="social-icon">
                        <i class="fab fa-twitter-square"></i>
                    </div>
                    <div class="social-icon">
                        <i class="fab fa-instagram-square"></i>
                    </div>
                    <div class="social-icon">
                        <i class="fab fa-linkedin"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="navigation-column">
            <div class="navigation-wrapper">
                <div class="navigation-title">Navigation</div>
                <div class="navigation-item">
                    <span class="fa fa-chevron-right mr-2"></span><a href="/" class="navigation-link">Dashboard</a>
                </div>
                <div class="navigation-item">
                    <span class="fa fa-chevron-right mr-2"></span><a href="/" class="navigation-link">Data Diri</a>
                </div>
                <div class="navigation-item">
                    <span class="fa fa-chevron-right mr-2"></span><a href="/" class="navigation-link">Pengajuan Surat Prasejahtera</a>
                </div>
            </div>
        </div>
        <div class="contact-column">
            <div class="contact-wrapper">
                <div class="contact-title">Contact Us</div>
                <div class="navigation-item">
                    <i class="fas fa-phone-alt"></i><div class="phone-text">(0341) 591310</div>
                </div>
                <div class="navigation-item">
                    <i class="fas fa-envelope"></i><div class="email-text">ramapb7b@gmail.com</div>
                </div>
            </div>
        </div>
    </div>
</footer>
<style>
    .container-footer {
        padding: 50px;
    }

    .container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }

    .row {
        display: flex;
        gap: 20px;
    }

    @media (max-width: 991px) {
        .row {
            flex-direction: column;
            align-items: stretch;
            gap: 0;
        }
    }

    .main-column {
        display: flex;
        flex-direction: column;
        line-height: normal;
        width: 40%;
        flex: 6;
    }

    @media (max-width: 991px) {
        .main-column {
            width: 100%;
        }
    }

    .image-wrapper {
        display: flex;
        flex-grow: 1;
        flex-direction: column;
        color: #000;
        font-weight: 400;
    }

    .location-image {
        aspect-ratio: 4.76;
        object-fit: auto;
        object-position: center;
        width: 100%;
    }

    @media (max-width: 991px) {
        .location-image {
            max-width: 100%;
        }
    }

    .address {
        margin-top: 50px;
        font: 17px Poppins, sans-serif;
    }

    @media (max-width: 991px) {
        .address {
            max-width: 100%;
            margin-top: 40px;
        }
    }

    .navigation-column {
        display: flex;
        flex-direction: column;
        line-height: normal;
        width: 20%;
        margin-left: 20px;
        flex: 2;
    }

    @media (max-width: 991px) {
        .navigation-column {
            width: 100%;
        }
    }

    .navigation-wrapper {
        display: flex;
        flex-direction: column;
        color: #000;
    }

    .navigation-title {
        letter-spacing: 1.75px;
        text-transform: uppercase;
        font: 900 25px Poppins, sans-serif;
    }

    .navigation-item {
        display: flex;
        margin-top: 39px;
        gap: 13px;
    }

    .navigation-icon {
        font: 900 20px Font Awesome 5 Free, -apple-system, Roboto, Helvetica, sans-serif;
    }

    .navigation-link {
        flex-grow: 1;
        flex-basis: auto;
        font: 400 17px Poppins, sans-serif;
        text-decoration: none;
        color: #000;
    }

    .contact-column {
        display: flex;
        flex-direction: column;
        line-height: normal;
        width: 20%;
        flex: 2;
        margin-left: 20px;
    }

    @media (max-width: 991px) {
        .contact-column {
            width: 100%;
        }
    }

    .contact-wrapper {
        display: flex;
        flex-direction: column;
        color: #000;
    }

    .contact-title {
        letter-spacing: 1.75px;
        text-transform: uppercase;
        font: 900 25px Poppins, sans-serif;
    }

    .phone-number {
        display: flex;
        margin-top: 51px;
        gap: 18px;
        font-size: 17px;
        font-weight: 400;
    }

    .phone-icon {
        aspect-ratio: 0.89;
        object-fit: auto;
        object-position: center;
        width: 26px;
    }

    .phone-text {
        font-family: Poppins, sans-serif;
        flex-grow: 1;
        flex-basis: auto;
    }

    .email {
        align-self: start;
        display: flex;
        gap: 11px;
        white-space: nowrap;
        margin: 24px 0 0 13px;
    }

    @media (max-width: 991px) {
        .email {
            margin-left: 10px;
            white-space: initial;
        }
    }

    .email-icon {
        align-self: start;
        font: 900 20px Font Awesome 5 Free, -apple-system, Roboto, Helvetica, sans-serif;
    }

    .email-text {
        font: 400 17px Poppins, sans-serif;
    }

    .social-icons {
        align-self: start;
        display: flex;
        margin-top: 67px;
        gap: 17px;
        font-size: 30px;
        white-space: nowrap;
    }
</style>


