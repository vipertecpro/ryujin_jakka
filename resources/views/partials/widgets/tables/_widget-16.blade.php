<div class="card card-flush h-xl-100">
    <div class="card-body pt-6">
        <ul class="nav nav-pills nav-pills-custom mb-3">
            <li class="nav-item mb-3 me-3 me-lg-6">
                <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-150px h-85px pt-5 pb-2 active"
                   href="{{ route('employees.index') }}">
                    <div class="nav-icon mb-3">{!! getIcon('car', 'fs-1') !!}</div>
                    <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">
                        Employees - {{ \App\Models\User::with(['roles'])->whereHas('roles',function($query){
                                            $query->where('name','!=','developer')->where('name','!=','customer')->where('name','!=','patient');
                                        })->count() }}
                    </span>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                </a>
            </li>
            <li class="nav-item mb-3 me-3 me-lg-6">
                <a class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden w-150px h-85px pt-5 pb-2 active"
                   href="{{ route('branches.index') }}">
                    <div class="nav-icon mb-3">{!! getIcon('like', 'fs-1') !!}</div>
                    <span
                            class="nav-text text-gray-800 fw-bold fs-6 lh-1">Branches - {{ \App\Models\Branch::count() }}</span>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                </a>
            </li>
        </ul>
    </div>
</div>
