<footer class="bg-light text-center text-white">

    <div class="container p-4 pb-0">
        <!-- Section: Social media -->
        <section class="mb-4">
            <!-- Facebook -->
            <a class="btn text-white btn-floating m-1" style="background-color: #3b5998" href="#!" role="button"><i
                    class="fab fa-facebook-f"></i></a>
            <!-- Twitter -->
            <a class="btn text-white btn-floating m-1" style="background-color: #55acee" href="#!" role="button"><i
                    class="fab fa-twitter"></i></a>
            <!-- Google -->
            <a class="btn text-white btn-floating m-1" style="background-color: #dd4b39" href="#!"
                role="button"><i class="fab fa-google"></i></a>
            <!-- Instagram -->
            <a class="btn text-white btn-floating m-1" style="background-color: #ac2bac" href="#!"
                role="button"><i class="fab fa-instagram"></i></a>
        </section>
        <!-- Section: Social media -->
        <section class="mb-4">
            <a id="btnAviso-legal" class="btn text-white">Aviso legal</a>
            <a id="btnCancelacion" class="btn text-white">Política de Cancelación</a>
        </section>
    </div>

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: #6fa78a; width: 100%">
        <p class="copyright">© 2023 Finca Monterruiz. Todos los derechos reservados.</p>
    </div>
    <!-- Copyright -->
</footer>

<script defer>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.getElementById('btnCancelacion').addEventListener('click', function() {
            window.open('/politica-cancelacion', '_blank');
        });

        document.getElementById('btnAviso-legal').addEventListener('click', function() {
            window.open('/aviso-legal', '_blank');
        });
    });
</script>
