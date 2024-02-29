@extends('layouts.back-end.app')

@section('title', translate('category'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-3">
            <h2 class="h1 mb-0 d-flex gap-10">
                <img src="{{ asset('public/assets/back-end/img/brand-setup.png') }}" alt="">
                {{ translate('category_Setup') }}
            </h2>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body text-start">
                        <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <ul class="nav nav-tabs w-fit-content mb-4">
                                @foreach($languages as $lang)
                                    <li class="nav-item text-capitalize">
                                        <span class="nav-link form-system-language-tab cursor-pointer {{ $lang == $defaultLanguage? 'active':''}}"
                                           id="{{ $lang}}-link">
                                            {{ucfirst(getLanguageName($lang)).'('.strtoupper($lang).')'}}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="row">
                                <div class="col-lg-6">
                                    <div>
                                        @foreach($languages as $lang)
                                            <div class="form-group {{ $lang != $defaultLanguage ? 'd-none':''}} form-system-language-form"
                                                 id="{{ $lang}}-form">
                                                <label class="title-color">{{ translate('category_Name') }}<span
                                                            class="text-danger">*</span> ({{strtoupper($lang) }})</label>
                                                <input type="text" name="name[]" class="form-control"
                                                       placeholder="{{ translate('new_Category') }}" {{ $lang == $defaultLanguage? 'required':''}}>
                                            </div>
                                            <input type="hidden" name="lang[]" value="{{ $lang}}">
                                        @endforeach
                                        <input name="position" value="0" class="d-none">
                                    </div>
                                    <div class="form-group">
                                        <label class="title-color" for="priority">{{ translate('priority') }}
                                            <span>
                                            <i class="tio-info-outined"
                                               title="{{ translate('the_lowest_number_will_get_the_highest_priority') }}"></i>
                                            </span>
                                        </label>

                                        <select class="form-control" name="priority" id="" required>
                                            <option disabled selected>{{ translate('set_Priority') }}</option>
                                            @for ($i = 0; $i <= 10; $i++)
                                                <option
                                                        value="{{ $i}}">{{ $i}}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="from_part_2">
                                        <label class="title-color">{{ translate('category_Logo') }}</label>
                                        <span class="text-info"><span class="text-danger">*</span> {{ THEME_RATIO[theme_root_path()]['Category Image'] }}</span>
                                        <div class="custom-file text-left">
                                            <input type="file" name="image" id="category-image"
                                                   class="custom-file-input image-preview-before-upload"
                                                   data-preview="#viewer"
                                                   accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*"
                                                   required>
                                            <label class="custom-file-label"
                                                   for="category-image">{{ translate('choose_File') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-4 mt-lg-0 from_part_2">
                                    <div class="form-group">
                                        <div class="text-center mx-auto">
                                            <img class="upload-img-view" id="viewer" alt=""
                                                src="{{ asset('public/assets/back-end/img/image-place-holder.png') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-2 justify-content-end">
                                <button type="reset" id="reset"
                                        class="btn btn-secondary">{{ translate('reset') }}</button>
                                <button type="submit" class="btn btn--primary">{{ translate('submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-20" id="cate-table">
            <div class="col-md-12">
                <div class="card">
                    <div class="px-3 py-4">
                        <div class="row align-items-center">
                            <div class="col-sm-4 col-md-6 col-lg-8 mb-2 mb-sm-0">
                                <h5 class="text-capitalize d-flex gap-1">
                                    {{ translate('category_list') }}
                                    <span class="badge badge-soft-dark radius-50 fz-12">{{ $categories->total() }}</span>
                                </h5>
                            </div>
                            <div class="col-sm-8 col-md-6 col-lg-4">
                                <form action="{{ url()->current() }}" method="GET">
                                    <div class="input-group input-group-custom input-group-merge">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="tio-search"></i>
                                            </div>
                                        </div>
                                        <input id="" type="search" name="searchValue" class="form-control"
                                               placeholder="{{ translate('search_here') }}"
                                               value="{{ request('searchValue') }}" required>
                                        <button type="submit" class="btn btn--primary">{{ translate('search') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100 text-start">
                            <thead class="thead-light thead-50 text-capitalize">
                            <tr>
                                <th>{{ translate('ID') }}</th>
                                <th class="text-center">{{ translate('category_Image') }}</th>
                                <th>{{ translate('name') }}</th>
                                <th>{{ translate('priority') }}</th>
                                <th class="text-center">{{ translate('home_category_status') }}</th>
                                <th class="text-center">{{ translate('action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $key=>$category)
                                <tr>
                                    <td>{{ $category['id'] }}</td>
                                    <td class="text-center">
                                        <div class="avatar-60 d-flex align-items-center rounded">
                                            <img class="img-fluid" alt=""
                                             src="{{ getValidImage(path: 'storage/app/public/category/'.$category['icon'], type: 'backend-category') }}">
                                        </div>
                                    </td>
                                    <td>{{ $category['defaultname'] }}</td>
                                    <td>
                                        {{ $category['priority'] }}
                                    </td>
                                    <td class="text-center">

                                        <form action="{{ route('admin.category.status') }}" method="post"
                                              id="category-status{{ $category['id'] }}-form">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $category['id'] }}">
                                            <label class="switcher mx-auto">
                                                <input type="checkbox" class="switcher_input toggle-switch-message" name="home_status"
                                                       id="category-status{{ $category['id'] }}" value="1" {{ $category['home_status'] == 1 ? 'checked' : '' }}
                                                       data-modal-id="toggle-status-modal"
                                                       data-toggle-id="category-status{{ $category['id'] }}"
                                                       data-on-image = "category-status-on.png"
                                                       data-off-image = "category-status-off.png"
                                                       data-on-title = "{{ translate('Want_to_Turn_ON').' '.$category['defaultname'].' '. translate('status') }}"
                                                       data-off-title = "{{ translate('Want_to_Turn_OFF').' '.$category['defaultname'].' '.translate('status') }}"
                                                       data-on-message = "<p>{{ translate('if_enabled_this_category_it_will_be_visible_from_the_category_wise_product_section_in_the_website_and_customer_app_in_the_homepage') }}</p>"
                                                       data-off-message = "<p>{{ translate('if_disabled_this_category_it_will_be_hidden_from_the_category_wise_product_section_in_the_website_and_customer_app_in_the_homepage') }}</p>">
                                                <span class="switcher_control"></span>
                                            </label>
                                        </form>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center gap-10">
                                            <a class="btn btn-outline-info btn-sm square-btn"
                                               title="{{ translate('edit') }}"
                                               href="{{ route('admin.category.update',[$category['id']]) }}">
                                                <i class="tio-edit"></i>
                                            </a>
                                            <a class="btn btn-outline-danger btn-sm square-btn category-delete-button"
                                               title="{{ translate('delete') }}"
                                               id="{{ $category['id'] }}">
                                                <i class="tio-delete"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="table-responsive mt-4">
                        <div class="d-flex justify-content-lg-end">
                            {{ $categories->links() }}
                        </div>
                    </div>

                    @if(count($categories) == 0)
                        <div class="text-center p-4">
                            <img class="mb-3 w-160"
                                 src="{{ asset('public/assets/back-end/svg/illustrations/sorry.svg') }}"
                                 alt="{{translate('image_description')}}">
                            <p class="mb-0">{{ translate('no_data_found') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <span id="route-admin-category-delete" data-url="{{ route('admin.category.delete') }}"></span>
@endsection

@push('script')
    <script src="{{ asset('public/assets/back-end/js/products-management.js') }}"></script>
@endpush
