<div class="tab-pane fade" id="security" role="tabpanel">
	<div class="card mb-xl-10">
		<div class="card-header cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
			<div class="card-title m-0">
				<h3 class="fw-bolder m-0">Seguridad</h3>
			</div>
		</div>
		<div class="card-body p-9">
            <div class="table-responsive">
				<table class="table align-middle table-row-dashed gy-5" id="kt_table_users_login_session">
					<tbody class="fs-6 fw-bold text-gray-600">
						<tr>
                            <td>Rol</td>
                            <td>{{ auth()->user()->getRoleNames()[0] }}</td>
                            <td class="text-end"></td>
						</tr>
						<tr>
							<td>Correo</td>
							<td>{{ auth()->user()->email }}</td>
							<td class="text-end"></td>
						</tr>
						<tr>
							<td>Contraseña</td>
							<td>********</td>
							<td class="text-end">
								<a 
                                    class="btn btn-icon w-30px h-30px ms-auto svg-icons"
                                    href="javascript:void(0);"
                                    onclick="modalShow('#update_password','{{ route("updatePassword") }}');">
									<span class="mx-1">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22H15C20 22 22 20 22 15V13" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M16.0418 3.01976L8.16183 10.8998C7.86183 11.1998 7.56183 11.7898 7.50183 12.2198L7.07183 15.2298C6.91183 16.3198 7.68183 17.0798 8.77183 16.9298L11.7818 16.4998C12.2018 16.4398 12.7918 16.1398 13.1018 15.8398L20.9818 7.95976C22.3418 6.59976 22.9818 5.01976 20.9818 3.01976C18.9818 1.01976 17.4018 1.65976 16.0418 3.01976Z" stroke="#4F4F4F" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M14.9102 4.1499C15.5802 6.5399 17.4502 8.4099 19.8502 9.0899" stroke="#4F4F4F" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </span>
                                </a>
							</td>
						</tr>
						<tr>
							<td>Factor doble autenticación (2FA)</td>
							<td>
								<div class="text-badge">
									<span class="text-status badge-status-{{auth()->user()->is_2fa ? 'enabled' : 'disabled'}}">
										{{ auth()->user()->is_2fa ? 'Habilitado' : 'Deshabilitado'}}
									</span>
								</div>
							</td>
							<td class="text-end">
								<a 
                                    class="btn btn-icon w-30px h-30px ms-auto svg-icons"
                                    href="javascript:void(0);"
                                    onclick="modalShow('#update_2fa','{{ route("auth.2fa.validate") }}');">
									<span class="mx-1">
										@if(auth()->user()->is_2fa === 0)
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M17 22H7C3 22 2 21 2 17V15C2 11 3 10 7 10H17C21 10 22 11 22 15V17C22 21 21 22 17 22Z" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M6 10V8C6 4.69 7 2 12 2C16.5 2 18 4 18 7" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M12 18.5C13.3807 18.5 14.5 17.3807 14.5 16C14.5 14.6193 13.3807 13.5 12 13.5C10.6193 13.5 9.5 14.6193 9.5 16C9.5 17.3807 10.6193 18.5 12 18.5Z" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
										@else
										<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
											<path d="M6 10V8C6 4.69 7 2 12 2C17 2 18 4.69 18 8V10" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M12 18.5C13.3807 18.5 14.5 17.3807 14.5 16C14.5 14.6193 13.3807 13.5 12 13.5C10.6193 13.5 9.5 14.6193 9.5 16C9.5 17.3807 10.6193 18.5 12 18.5Z" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
											<path d="M17 22H7C3 22 2 21 2 17V15C2 11 3 10 7 10H17C21 10 22 11 22 15V17C22 21 21 22 17 22Z" stroke="#4F4F4F" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
										</svg>
										@endif
                                    </span>
                                </a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>