    <section class="bg-lighter checkout">
        <div class="container">
            <div class="rw-flex">
                <!-- Start Checkout Details-->
                <div class="main-box" style="width: 100%;">
                    <div class="success-box">
                        <p>Your booking successfully & Our team will shortly get in touch with you.</p>
                        <p>Our Team Will Contact You Shortly.</p>
                        <p>Thank You!</p>
                        <p><a href="<?php echo site_url(); ?>" style="color: blue;font-size: 12px;">
                                << Back</a>
                        </p>
                        <!--End Login Popup-->
                    </div>
                </div>
                <!-- End  Checkout Details-->
            </div>
        </div>
    </section>
    <?php
    unset($_SESSION['sessionBookingId']);
    ?>
    <script type="text/javascript">
        $(function() {
            setTimeout(function() {
                 window.location.replace("<?php echo site_url() ?>");
            }, 5000);
        });
        // disable right click 
        if (document.layers) {
            document.captureEvents(Event.MOUSEDOWN);
            document.onmousedown = function() {
                return false;
            };
        } else {
            document.onmouseup = function(e) {
                if (e != null && e.type == "mouseup") {
                    if (e.which == 2 || e.which == 3) {
                        return false;
                    }
                }
            };
        }
        //Disable the Context Menu event.
        document.oncontextmenu = function() {
            return false;
        };
        document.onkeydown = ShowKeyCode;

        function ShowKeyCode(evt) {
            if ((evt.keyCode == '123') || (evt.keyCode == '17'))
                return false;
        }
    </script>
    <script>
        document.onkeydown = function(e) {
            if (e.ctrlKey &&
                (e.keyCode === 67 ||
                    e.keyCode === 86 ||
                    e.keyCode === 85 ||
                    e.keyCode === 117)) {
                return false;
            } else {
                return true;
            }
        };
        $(document).keypress("u", function(e) {
            if (e.ctrlKey) {
                return false;
            } else {
                return true;
            }
        });
    </script>