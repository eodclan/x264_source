<?php
echo("
            </div>
            <!-- /.conainer-fluid -->
        </main>
    </div>
    <footer class='app-footer'>
        Powered by D€ Source 2017 Version ".$GLOBALS["X264VERSION"]."
        <span class='float-right'>
            ".$GLOBALS["X264COPYRIGHT"]."
        </span>
    </footer>

    <script>
        // Hide loader
        (function() {
            var bodyElement = document.querySelector('body');
            bodyElement.classList.add('loading');

            document.addEventListener('readystatechange', function() {
                if(document.readyState === 'complete') {
                    var bodyElement = document.querySelector('body');
                    var loaderElement = document.querySelector('#initial-loader');

                    bodyElement.classList.add('loaded');
                    setTimeout(function() {
                        bodyElement.removeChild(loaderElement);
                        bodyElement.classList.remove('loading', 'loaded');
                    }, 200);
                }
            });
        })();
    </script>

    <!-- Bootstrap and necessary plugins -->
    <script src='/design/ex1080_default/js/libs/jquery.min.js'></script>
    <script src='/design/ex1080_default/js/libs/tether.min.js'></script>
    <script src='/design/ex1080_default/js/libs/bootstrap.min.js'></script>
    <script src='/design/ex1080_default/js/libs/pace.min.js'></script>
    <!-- GenesisUI main scripts -->
    <script src='/design/ex1080_default/js/app.js'></script>
    <!-- Plugins and scripts required by this views -->
    <script src='/design/ex1080_default/js/libs/toastr.min.js'></script>
    <script src='/design/ex1080_default/js/libs/gauge.min.js'></script>
    <script src='/design/ex1080_default/js/libs/moment.min.js'></script>
    <script src='/design/ex1080_default/js/libs/daterangepicker.js'></script>
</body>
</html>"); 
?>