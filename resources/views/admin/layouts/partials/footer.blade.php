<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="text-center">
					&copy;
					<script>
						document.write(new Date().getFullYear())
					</script> {{ config('app.name') }}. Creado con 
					<i class="mdi mdi-heart text-danger"></i> 
					por 
					<a href="{{ env('URL_CODANT') }}" target="_blank" class="text-decoration-none text-white">
						{{ env('NAME_CODANT') }}
					</a>
				</div>
			</div>
		</div>
	</div>
</footer>