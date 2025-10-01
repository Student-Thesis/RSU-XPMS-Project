</div>
</div>

<!-- Core libraries -->
<script src="{{ asset($basePath . '/js/jquery.min.js') }}"></script>
<script src="{{ asset($basePath . '/js/popper.min.js') }}"></script>
<script src="{{ asset($basePath . '/js/bootstrap.min.js') }}"></script>

<!-- Extra plugins -->
<script src="{{ asset($basePath . '/js/bootstrap-select.js') }}"></script>
<script src="{{ asset($basePath . '/js/perfect-scrollbar.min.js') }}"></script>
<script>
    var ps = new PerfectScrollbar('#sidebar');
</script>

<!-- Animation -->
<script src="{{ asset($basePath . '/js/animate.js') }}"></script>

<!-- Owl carousel -->
<script src="{{ asset($basePath . '/js/owl.carousel.js') }}"></script>

<!-- Chart.js -->
<script src="{{ asset($basePath . '/js/Chart.min.js') }}"></script>
<script src="{{ asset($basePath . '/js/Chart.bundle.min.js') }}"></script>
<script src="{{ asset($basePath . '/js/utils.js') }}"></script>
<script src="{{ asset($basePath . '/js/analyser.js') }}"></script>

<!-- FullCalendar (CDN – keep as is unless downloaded locally) -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<!-- Custom scripts -->
<script src="{{ asset($basePath . '/js/chart_custom_style1.js') }}"></script>
<script src="{{ asset($basePath . '/js/custom.js') }}"></script>

<!-- Bootstrap 5 bundle (CDN – same note as above) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
