@extends('admin.layouts.master')
@section('content')

<form action="{{ route('app-setting-update') }}" method="POST" class="card" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="old_app_logo" value="{{ $appsetting->app_logo }}">
    <div class="row row-deck">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">App Setting</h3>
                <div class="card-options">
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-outline-primary" data-toggle="tooltip" data-placement="right" title="Go To Back"><i class="fa fa-mail-reply"></i></a>
                </div>
            </div>
            <div class="card-body row">
                <div class="form-group col-sm-6">
                    <label for="app_name" class="form-label">App Name</label>
                    <input type="text" id="app_name" name="app_name" class="{{ $errors->has('app_name') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="App Name" autocomplete="off" required value="{{ $appsetting->app_name }}">
                    @if ($errors->has('app_name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('app_name') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group col-sm-6">
                    <label for="email" class="form-label">Header Email</label>
                    <input type="text" id="email" name="email" class="{{ $errors->has('email') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Email" autocomplete="off" required value="{{ $appsetting->email }}">
                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group col-sm-6">
                    <label for="mobilenum" class="form-label">Header Mobile / Contact Number</label>
                    <input type="text" id="mobilenum" name="mobilenum" class="{{ $errors->has('mobilenum') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Mobile / Contact Number" autocomplete="off" required value="{{ $appsetting->mobilenum }}">
                    @if ($errors->has('mobilenum'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('mobilenum') }}</strong>
                    </span>
                    @endif
                </div>

                <!-- Default Language -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="default_language" class="form-label">Default Language</label>
                        <select name="default_language" id="default_language" class="form-control">
                            <option value="">Select Language</option>
                            @foreach(App\Models\Language::all() as $lang)
                                <option value="{{ $lang->id }}" {{ $lang->id == $appsetting->default_language ? 'selected' : '' }}>{{ $lang->name }}</option>
                            @endforeach
                        </select>
                        @error('default_language')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('default_language') }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <!-- Default Currency -->
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="default_currency" class="form-label">Default Currency</label>
                        <select name="default_currency" id="default_currency" class="form-control">
                            <option value="">Select Currency</option>
                            @foreach(App\Models\Currency::all() as $lang)
                                <option value="{{ $lang->id }}" {{ $lang->id == $appsetting->default_currency ? 'selected' : '' }}>{{ $lang->name }}</option>
                            @endforeach
                        </select>
                        @error('default_currency')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('default_currency') }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group col-sm-12">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" id="address" name="address" class="{{ $errors->has('address') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Address" autocomplete="off" required value="{{ $appsetting->address }}">
                    @if ($errors->has('address'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group col-sm-12">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" class="{{ $errors->has('description') ? 'form-control is-invalid state-invalid' : 'form-control' }} ckeditor" placeholder="Description" autocomplete="off" rows="1">{{ $appsetting->description }}</textarea>
                    @if ($errors->has('description'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group col-sm-12">
                    <label for="footer_description" class="form-label">Footer Description</label>
                    <textarea id="footer_description" name="footer_description" class="{{ $errors->has('footer_description') ? 'form-control is-invalid state-invalid' : 'form-control' }} ckeditor" placeholder="Footer Description" autocomplete="off" rows="1">{{ $appsetting->footer_description }}</textarea>
                    @if ($errors->has('footer_description'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('footer_description') }}</strong>
                    </span>
                    @endif
                </div>
                    <div class="form-group col-sm-3">
                        <label for="app_logo" class="form-label">Logo ( W:120 H:50 in PX)</label>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                <img id="imageThumb" src="{{ url('/') }}/{!! $appsetting->app_logo !!}"> 
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        </div>
                        <div>
                            <span class="btn btn-outline-primary btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
                                <input type="file" name="app_logo" id="app_logo" accept="image/*" onchange="readURL(this,'imageThumb')">
                            </span> 
                        </div>
                        @if ($errors->has('app_logo'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('app_logo') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="fav_icon" class="form-label">Fav Icon ( W:60 H:60 in PX)</label>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                <img id="imageThumb1" src="{{ url('/') }}/{!! $appsetting->fav_icon !!}"> 
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        </div>
                        <div>
                            <span class="btn btn-outline-primary btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
                                <input type="file" name="fav_icon" id="fav_icon" accept="image/*" onchange="readURL(this,'imageThumb1')">
                            </span> 
                        </div>
                        @if ($errors->has('fav_icon'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('fav_icon') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="footer_logo" class="form-label">Footer Logo ( W:300 H:100 in PX)</label>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                <img id="imageThumb2" src="{{ url('/') }}/{!! $appsetting->footer_logo !!}"> 
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        </div>
                        <div>
                            <span class="btn btn-outline-primary btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
                                <input type="file" name="footer_logo" id="footer_logo" accept="image/*" onchange="readURL(this,'imageThumb2')">
                            </span> 
                        </div>
                        @if ($errors->has('footer_logo'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('footer_logo') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="payment_image" class="form-label">Payment Image ( W:350 H:100 in PX)</label>
                        <div class="fileupload fileupload-new" data-provides="fileupload">
                            <div class="fileupload-new thumbnail" style="width: 200px; height: 150px;">
                                <img id="imageThumb3" src="{{ url('/') }}/{!! $appsetting->payment_image !!}"> 
                            </div>
                            <div class="fileupload-preview fileupload-exists thumbnail" style="max-width: 200px; max-height: 150px; line-height: 20px;"></div>
                        </div>
                        <div>
                            <span class="btn btn-outline-primary btn-file">
                                <span class="fileupload-new"><i class="fa fa-paper-clip"></i> Select Image</span>
                                <input type="file" name="payment_image" id="payment_image" accept="image/*" onchange="readURL(this,'imageThumb3')">
                            </span> 
                        </div>
                        @if ($errors->has('payment_image'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('payment_image') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="fb_url" class="form-label">FaceBook Url</label>
                        <input type="text" id="fb_url" name="fb_url" class="{{ $errors->has('fb_url') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="FaceBook Url" autocomplete="off" value="{{ $appsetting->fb_url }}">
                        @if ($errors->has('fb_url'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('fb_url') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="twitter_url" class="form-label">Twitter Url</label>
                        <input type="text" id="twitter_url" name="twitter_url" class="{{ $errors->has('twitter_url') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Twitter Url" autocomplete="off" value="{{ $appsetting->twitter_url }}">
                        @if ($errors->has('twitter_url'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('twitter_url') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="insta_url" class="form-label">Instagram Url</label>
                        <input type="text" id="insta_url" name="insta_url" class="{{ $errors->has('insta_url') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Instagram Url" autocomplete="off" value="{{ $appsetting->insta_url }}">
                        @if ($errors->has('insta_url'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('insta_url') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="linkedIn_url" class="form-label">LinkedIn Url</label>
                        <input type="text" id="linkedIn_url" name="linkedIn_url" class="{{ $errors->has('linkedIn_url') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="FaceBook Url" autocomplete="off" value="{{ $appsetting->linkedIn_url }}">
                        @if ($errors->has('linkedIn_url'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('linkedIn_url') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="pinterest_url" class="form-label">Pinterest Url</label>
                        <input type="text" id="pinterest_url" name="pinterest_url" class="{{ $errors->has('pinterest_url') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="FaceBook Url" autocomplete="off" value="{{ $appsetting->pinterest_url }}">
                        @if ($errors->has('pinterest_url'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('pinterest_url') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-6">
                        <label for="copyright_text" class="form-label">CopyRight Text</label>
                        <input type="text" id="copyright_text" name="copyright_text" class="{{ $errors->has('copyright_text') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="CopyRight Text" autocomplete="off" value="{{ $appsetting->copyright_text }}">
                        @if ($errors->has('copyright_text'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('copyright_text') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="pro_forma_invoice_remarks" class="form-label">Pro Forma Invoice Remarks</label>
                        <input type="text" id="pro_forma_invoice_remarks" name="pro_forma_invoice_remarks" class="{{ $errors->has('pro_forma_invoice_remarks') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Twitter Url" autocomplete="off" value="{{ $appsetting->pro_forma_invoice_remarks }}">
                        @if ($errors->has('pro_forma_invoice_remarks'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('pro_forma_invoice_remarks') }}</strong>
                        </span>
                        @endif
                    </div>
                    <div class="form-group col-sm-12">
                        <label for="contact_title" class="form-label">Contact Title</label>
                        <input type="text" id="contact_title" name="contact_title" class="{{ $errors->has('contact_title') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Address" autocomplete="off" required value="{{ $appsetting->contact_title }}">
                        @if ($errors->has('contact_title'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('contact_title') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group col-sm-12">
                        <label for="contact_description" class="form-label">Contact Description</label>
                        <textarea id="contact_description" name="contact_description" class="{{ $errors->has('contact_description') ? 'form-control is-invalid state-invalid' : 'form-control' }} content2" placeholder="Description" autocomplete="off" rows="1">{{ $appsetting->contact_description }}</textarea>
                        @if ($errors->has('contact_description'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('contact_description') }}</strong>
                        </span>
                        @endif
                    </div>
                <div class="card-header">
                    <h3 class="card-title">SEO / Google Analytics</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="seo_keyword" class="form-label">SEO Keywords</label>
                                <textarea id="seo_keyword" name="seo_keyword" class="{{ $errors->has('seo_keyword') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="SEO Keywords" autocomplete="off" rows="1">{{ $appsetting->seo_keyword }}</textarea>
                                @if ($errors->has('seo_keyword'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('seo_keyword') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="seo_description" class="form-label">SEO Description</label>
                                <textarea id="seo_description" name="seo_description" class="{{ $errors->has('seo_description') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="SEO Description" autocomplete="off" rows="1">{{ $appsetting->seo_description }}</textarea>
                                @if ($errors->has('seo_description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('seo_description') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="google_analytics" class="form-label">Google Analytics <pre>Without script tag</pre></label>
                                <textarea id="google_analytics" name="google_analytics" class="{{ $errors->has('google_analytics') ? 'form-control is-invalid state-invalid' : 'form-control' }}" placeholder="Google Analytics" autocomplete="off" rows="1">{{ $appsetting->google_analytics }}</textarea>
                                @if ($errors->has('google_analytics'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('google_analytics') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="ads_enabled" class="form-label">Ads Enabled</label>
                            <input type="checkbox" name="ads_enabled" value="1" {{ $appSetting->ads_enabled == 1 ? 'checked' : '' }}>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-footer text-right">
                                <button type="submit" class="btn btn-primary">Update App Setting</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('extrajs')
<script type="text/javascript">
    document.querySelectorAll('.ckeditor').forEach(function(textarea) {
        CKEDITOR.replace(textarea);
    });
</script>

@endsection
