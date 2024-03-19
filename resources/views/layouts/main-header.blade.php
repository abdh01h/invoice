<!-- main-header opened -->
			<div class="main-header sticky side-header nav nav-item">
				<div class="container-fluid">
					<div class="main-header-left ">
						<div class="responsive-logo">
							<a href="{{ route('home') }}">
                                {{-- <img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-2" alt="logo"> --}}
                                {{ config('app.name') }}
                            </a>
						</div>
						<div class="app-sidebar__toggle" data-toggle="sidebar">
							<a class="open-toggle" href="#"><i class="header-icon fe fe-align-left" ></i></a>
							<a class="close-toggle" href="#"><i class="header-icons fe fe-x"></i></a>
						</div>
					</div>
					<div class="main-header-right">
						<div class="nav nav-item  navbar-nav-right ml-auto">
							<div class="dropdown nav-item main-header-message ">
								<a class="new nav-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                @if(auth()->user()->unreadNotifications->count())
                                    <span class=" pulse"></span>
                                @endif
                                </a>
								<div class="dropdown-menu">
									<div class="menu-header-content bg-primary text-start">
                                        <div class="d-flex justify-content-between">
                                            <h6 class="dropdown-title mb-1 tx-15 text-white fw-semibold">
                                                Notifications
                                            </h6>
                                            @if(auth()->user()->unreadNotifications->count())
                                                <a href="{{ url('notifications/mark-all') }}" class="badge rounded-pill bg-warning ms-auto my-auto text-dark">
                                                    Mark All Read
                                                </a>
                                            @endif
                                        </div>
                                        @if(auth()->user()->unreadNotifications->count())
                                            <p class="dropdown-title-text subtext mb-0 text-white op-6 pb-0 tx-12 ">
                                                You have {{ auth()->user()->unreadNotifications->count() }} unread Notifications
                                            </p>
                                        @endif
                                    </div>
                                    @forelse(auth()->user()->unreadNotifications as $notification)
                                        <div class="main-message-list chat-scroll">
                                            <a href="{{ route('invoice_details.index', $notification->data['id']) }}" class="p-3 d-flex border-bottom">
                                                <div class="wd-90p">
                                                    <div class="d-flex">
                                                        <h5 class="mb-1 name">
                                                            {{ $notification->data['title'] }}
                                                        </h5>
                                                    </div>
                                                    <p class="mb-0 desc">
                                                        {{ date('d M, Y', strtotime($notification->created_at)) }}
                                                        At
                                                        {{ date('h:i A', strtotime($notification->created_at)) }}
                                                    </p>
                                                </div>
                                            </a>
                                        </div>
                                    @empty
                                        <div class="main-message-list chat-scroll">
                                            <div class="p-3 d-flex border-bottom">
                                                <div class="wd-90p">
                                                    <div class="text-center">
                                                        No Notifications!
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
									<a href="{{ route('notifications.index') }}">
                                        <div class="text-center dropdown-footer">
										    View All
									    </div>
                                    </a>
								</div>
							</div>
							<div class="dropdown main-profile-menu nav nav-item nav-link">
								<a class="profile-user d-flex" href="">
                                    @if(Auth::user()->avatar == '')
                                        <img alt="Avatar" src="{{ Avatar::create(Auth::user()->name)->setDimension(128, 128)->toBase64() }}">
                                    @else
                                        <img src="{{ asset(Auth::user()->avatar) }}" class="rounded-circle" alt="Avatar">
                                    @endif
                                </a>
								<div class="dropdown-menu">
									<div class="main-header-profile bg-primary p-3">
										<div class="d-flex wd-100p">
											<div class="main-img-user">
                                                @if(Auth::user()->avatar == '')
                                                <img alt="Avatar" src="{{ Avatar::create(Auth::user()->name)->setDimension(128, 128)->toBase64() }}" class="">
                                                @else
                                                    <img src="{{ asset(Auth::user()->avatar) }}" class="rounded-circle" alt="Avatar">
                                                @endif
                                            </div>
											<div class="m-2 my-auto">
												<h6>{{ Auth::user()->name }}</h6>
                                                <span>{{ Auth::user()->email }}</span>
											</div>
										</div>
									</div>
									<a class="dropdown-item" href="{{ route('profile.index') }}"><i class="bx bx-user-circle"></i>My Profile</a>
									<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bx bx-log-out"></i> {{ __('Logout') }}</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<!-- /main-header -->
