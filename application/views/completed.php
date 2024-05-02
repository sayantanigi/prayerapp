<style>
.modal-active{display:inline-block;top:67%}
.Donate_Btn {top: 105% !important;}
</style>
<?php $settings = $this->db->query("SELECT * FROM setting")->row(); ?>
<section class="container Data_Container">
    <div class="row">
        <div class="col-md-6 col-sm-12 form">
            <div class="contact__wrapper">
                <div class="section__title-wrapper mb-40">
                    <h2 class="section__title" style="margin-top: 25px;color: #000;">Get in touch</h2>
                </div>
                <p class="e_error" style="color: #db3636;">* All fields are mandatory</p>
                <p class="e_cerror" style="color: #db3636;">* Please check checkbox</p>
                <div class="contact__form">
                    <form id="contact-form">
                        <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-md-6">
                                <div class="contact__form-input">
                                    <input class="from-control" type="text" id="name" name="name" placeholder="Your Name" required="">
                                </div>
                            </div>
                            <div class="col-xxl-6 col-xl-6 col-md-6">
                                <div class="contact__form-input">
                                    <input class="from-control" type="text" id="email" name="email" placeholder="Your Email" required="">
                                </div>
                            </div>
                            <div class="col-xxl-6">
                                <div class="contact__form-input">
                                    <input class="from-control" type="text" id="subject" name="subject" placeholder="Subject" required="">
                                </div>
                            </div>
                            <div class="col-xxl-6">
                                <div class="contact__form-input">
                                    <input class="from-control" type="text" id="phone" name="phone" placeholder="Contact Number" required="" maxlength="10">
                                </div>
                            </div>
                            <div class="col-xxl-12">
                                <div class="contact__form-input">
                                    <textarea class="from-control" id="message" name="message" placeholder="Enter Your Message" required=""></textarea>
                                </div>
                            </div>
                            <div class="col-xxl-12">
                                <div class="contact__btn">
                                    <button type="button" class="e-btn" onclick="send_message()">Send your message</button>
                                </div>
                            </div>
                            <div class="success_msg"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12 data">
            <div class="contact__info white-bg p-relative z-index-1 rounded">
                <div class="contact__info-inner white-bg">
                    <ul>
                        <li style="list-style: none;">
                            <div class="contact__info-item d-flex align-items-start mb-35"
                                style="margin-bottom: 35px;">
                                <div class="contact__info-icon mr-15" style="margin-right: 15px;">
                                    <svg class="map" viewBox="0 0 24 24">
                                        <path class="st0" d="M21,10c0,7-9,13-9,13s-9-6-9-13c0-5,4-9,9-9S21,5,21,10z"></path>
                                        <circle class="st0" cx="12" cy="10" r="3"></circle>
                                    </svg>
                                </div>
                                <div class="contact__info-text">
                                    <h4 class="text-dark"> Office Address</h4>
                                    <p><?= $settings->address; ?></p>
                                </div>
                            </div>
                        </li>
                        <li style="list-style: none;">
                            <div class="contact__info-item d-flex align-items-start mb-35" style="margin-bottom: 35px;">
                                <div class="contact__info-icon mr-15" style="margin-right: 15px;">
                                    <svg class="mail" viewBox="0 0 24 24">
                                        <path class="st0" d="M4,4h16c1.1,0,2,0.9,2,2v12c0,1.1-0.9,2-2,2H4c-1.1,0-2-0.9-2-2V6C2,4.9,2.9,4,4,4z">
                                        </path>
                                        <polyline class="st0" points="22,6 12,13 2,6 "></polyline>
                                    </svg>
                                </div>
                                <div class="contact__info-text">
                                    <h4 class="text-dark">Email us directly</h4>
                                    <p><a href="mailto:<?= $settings->email; ?>"><?= $settings->email; ?></a></p>
                                </div>
                            </div>
                        </li>
                        <li style="list-style: none;">
                            <div class="contact__info-item d-flex align-items-start mb-35"
                                style="margin-bottom: 35px;">
                                <div class="contact__info-icon mr-15" style="margin-right: 15px;">
                                    <svg class="call" viewBox="0 0 24 24">
                                        <path class="st0" d="M22,16.9v3c0,1.1-0.9,2-2,2c-0.1,0-0.1,0-0.2,0c-3.1-0.3-6-1.4-8.6-3.1c-2.4-1.5-4.5-3.6-6-6  c-1.7-2.6-2.7-5.6-3.1-8.7C2,3.1,2.8,2.1,3.9,2C4,2,4.1,2,4.1,2h3c1,0,1.9,0.7,2,1.7c0.1,1,0.4,1.9,0.7,2.8c0.3,0.7,0.1,1.6-0.4,2.1  L8.1,9.9c1.4,2.5,3.5,4.6,6,6l1.3-1.3c0.6-0.5,1.4-0.7,2.1-0.4c0.9,0.3,1.8,0.6,2.8,0.7C21.3,15,22,15.9,22,16.9z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="contact__info-text">
                                    <h4 class="text-dark">Phone</h4>
                                    <p><a href="tel:<?= $settings->phone; ?>"><?= $settings->phone; ?></a></p>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="contact__social">
                        <h4 class="text-dark">Follow Us</h4>
                        <ul>
                            <li><a href="<?= @$settings->fb_link; ?>" class="fb"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="<?= @$settings->tw_link; ?>" class="tw"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="<?= @$settings->insta_link; ?>" class="pin"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="banner">
    <div class="container">
        <div class="banner_inner">
            <h1>Try our Prayer app for more things to do</h1>
            <div class="d-flex icon_flex">
                <a href="https://play.google.com/store/apps/details?id=com.onetwentyarmyprayer"><img src="<?= base_url() ?>assets/images/playstoreicon.png" alt=""> Play Store</a>
                <a href="https://apps.apple.com/us/app/120-army-prayer/id6478201470"><img src="<?= base_url() ?>assets/images/iphoneicon.png" alt=""> App Store</a>
            </div>
        </div>
    </div>
</section>