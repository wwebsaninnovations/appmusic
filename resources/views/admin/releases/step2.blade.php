@extends('admin.layouts.app')

@section('content')
<div class="container mt-5 tracks">
    <div class="row">
        <div class="col-md-12 tabs-item release-nav-link">
            <!-- Nav tabs -->
            <div class="nav  nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                @if(!$release->form_status)
                
                <div class="nav-item">
                    <a class="nav-link {{($level=='basic') ? 'active' : ''}}" id="v-pills-basic-tab" data-bs-toggle="pill" href="#v-pills-basic" role="tab" aria-controls="v-pills-basic" aria-selected="true" data-href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'basic'])}}">Basic</a>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{($level=='artwork') ? 'active' : ''}}" id="v-pills-artwork-tab" data-bs-toggle="pill" href="#v-pills-artwork" role="tab" aria-controls="v-pills-artwork" aria-selected="false" data-href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'artwork'])}}">Artwork</a>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{($level=='uploadtrack') ? 'active' : ''}}" id="v-pills-uploadtrack-tab" data-bs-toggle="pill" href="#v-pills-uploadtrack" role="tab" aria-controls="v-pills-uploadtrack" aria-selected="false" data-href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'uploadtrack'])}}">Upload Track</a>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{($level=='edittrack') ? 'active' : ''}}" id="v-pills-edittrack-tab" data-bs-toggle="pill" href="#v-pills-edittrack" role="tab" aria-controls="v-pills-edittrack" aria-selected="false" data-href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'edittrack'])}}">Edit Track</a>
                </div>
                <div class="nav-item">
                    <a class="nav-link {{($level=='platforms') ? 'active' : ''}}" id="v-pills-platforms-tab" data-bs-toggle="pill" href="#v-pills-platforms" role="tab" aria-controls="v-pills-platforms" aria-selected="false" data-href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'platforms'])}}">Platforms</a>
                </div>

                @endif

                <div class="nav-item">
                    <a class="nav-link {{($level=='summary') ? 'active' : ''}}" id="v-pills-summary-tab" data-bs-toggle="pill" href="#v-pills-summary" role="tab" aria-controls="v-pills-summary" aria-selected="false" data-href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'summary'])}}">Summary</a>
                </div>
                @canany(['approve-release' ])
                <div class="nav-item">
                    <a class="nav-link {{($level=='control_release') ? 'active' : ''}}" id="v-pills-control_release-tab" data-bs-toggle="pill" href="#v-pills-control_release" role="tab" aria-controls="v-pills-control_release" aria-selected="false" data-href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'control_release'])}}">Release</a>
                </div>

                @endcanany
                
            </div>
        </div>

        <div class="col-md-12">
          
            @if ($message = Session::get('success'))
                <div class="alert alert-success text-center" role="alert">
                    {{ $message }}
                </div>
            @endif
            <!-- Tab panes -->
            <div class="tab-content" id="v-pills-tabContent">

                <div class="tab-pane fade  {{($level=='basic')? ' show active':''}}" id="v-pills-basic" role="tabpanel" aria-labelledby="v-pills-basic-tab">
                <h5 class="siteTitle">Basic Information</h5>
                    <form action="{{ route('releases.basic.save') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="upc" class="form-label">UPC (Only Numeric)</label>
                                <input type="text" class="form-control" id="upc" name="upc" value="{{ old('upc', $release->upc ?? '') }}">
                                @if ($errors->has('upc'))
                                    <div class="text-danger">
                                        {{ $errors->first('upc') }}
                                    </div>
                                @endif
                                <input type="hidden" name="release_id" value="{{ $release->id }}">
                                <input type="hidden" name="summary" value="{{ $summary ?? '' }}">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="release_code" class="form-label">Release Code (Only Numeric)</label>
                                <input type="text" class="form-control" id="release_code" name="release_code" value="{{ old('release_code', $release->release_code ?? '') }}">
                                @if ($errors->has('release_code'))
                                    <div class="text-danger">
                                        {{ $errors->first('release_code') }}
                                    </div>
                                @endif
                                </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="meta_language" class="form-label">Meta Language<span class="required">*</span></label>
                                
                                <select class="form-select" id="meta_language" name="meta_language">
                                    <option value="" disabled selected>Select a language</option>
                                    @foreach($languages as $language)
                                        <option value="{{ $language->name }}" {{ old('meta_language', $release->meta_language) == $language->name ? 'selected' : '' }}>
                                            {{ $language->name }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('meta_language'))
                                    <div class="text-danger">
                                        {{ $errors->first('meta_language') }}
                                    </div>
                                @endif


                            </div>

                            <div class="col-6 mb-3">
                                <label for="release_name" class="form-label">Release Name<span class="required">*</span></label>
                                <input type="text" class="form-control" id="release_name" name="release_name" value="{{ old('release_name', $release->release_name ?? '') }}">
                                @if ($errors->has('release_name'))
                                    <div class="text-danger">
                                        {{ $errors->first('release_name') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="release_version" class="form-label">Release Version</label>
                                <input type="text" class="form-control" id="release_version" name="release_version" value="{{ old('release_version', $release->release_version ?? '') }}">
                                @if ($errors->has('release_version'))
                                    <div class="text-danger">
                                        {{ $errors->first('release_version') }}
                                    </div>
                                @endif
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12">
                                <h5 class="siteTitle">Artist & Contributor</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="primary_artist_basic" class="form-label">Primary Artist<span class="required">*</span></label>
                                <input type="text" class="form-control" id="primary_artist_basic" name="primary_artist_basic" value="{{ old('primary_artist_basic', $release->primary_artist ?? '') }}">
                                @if ($errors->has('primary_artist_basic'))
                                    <div class="text-danger">
                                        {{ $errors->first('primary_artist_basic') }}
                                    </div>
                                @endif
                                <div id="suggestions"></div>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="featuring_artist_basic" class="form-label">Featuring Artist</label>
                                <input type="text" class="form-control" id="featuring_artist_basic" name="featuring_artist_basic" value="{{ old('featuring_artist_basic', $release->featuring_artist ?? '') }}">
                                @if ($errors->has('featuring_artist_basic'))
                                    <div class="text-danger">
                                        {{ $errors->first('featuring_artist_basic') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="remixer_artist_basic" class="form-label">Remixer</label>
                                <input type="text" class="form-control" id="remixer_artist_basic" name="remixer_artist_basic" value="{{ old('remixer_artist_basic', $release->remixer ?? '') }}">
                                @if ($errors->has('remixer_artist_basic'))
                                    <div class="text-danger">
                                        {{ $errors->first('remixer_artist_basic') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <label for="producer_artist_basic" class="form-label">Producer<span class="required">*</span></label>
                                <input type="text" class="form-control" id="producer_artist_basic" name="producer_artist_basic" value="{{ old('producer_artist_basic', $release->producer ?? '') }}">
                                @if ($errors->has('producer_artist_basic'))
                                    <div class="text-danger">
                                        {{ $errors->first('producer_artist_basic') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h5>Release Details</h5>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="genre" class="form-label">Genre<span class="required">*</span></label>
                                    <select name="genre" id="genre" class="form-control @error('genre') is-invalid @enderror">
                                        @foreach($genres as $genre)
                                            <option value="{{ $genre->name }}" {{ old('genre', $release->genre) == $genre->name ? 'selected' : '' }}>
                                                {{ ucfirst($genre->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('genre'))
                                        <div class="text-danger">
                                            {{ $errors->first('genre') }}
                                        </div>
                                    @endif
                            </div>

                            <div class="col-6 mb-3">
                                <label for="sub_genre" class="form-label">Sub Genre</label>
                                <select class="form-select" id="sub_genre" name="sub_genre">
                                    <option value="">Select Sub Genre</option>
                                        @foreach($genres as $genre)
                                            <option value="{{ $genre->name }}" {{ old('sub_genre', $release->sub_genre) == $genre->name ? 'selected' : '' }}>
                                                {{ ucfirst($genre->name) }}
                                            </option>
                                        @endforeach
                                </select>
                                @if ($errors->has('sub_genre'))
                                    <div class="text-danger">
                                        {{ $errors->first('sub_genre') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-6 mb-3">
                                <label for="format" class="form-label">Format<span class="required">*</span></label>
                                <select class="form-select" id="format" name="format">
                                    <option value="">Select Format</option>
                                    <option value="single" {{ old('format', $release->format) == 'single' ? 'selected' : '' }}>Single</option>
                                    <option value="ep" {{ old('format', $release->format) == 'ep' ? 'selected' : '' }}>EP</option>
                                    <option value="album" {{ old('format', $release->format) == 'album' ? 'selected' : '' }}>Album</option>
                                </select>
                                @if ($errors->has('format'))
                                    <div class="text-danger">
                                        {{ $errors->first('format') }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-6 mb-3">
                                <label for="pname_basic" class="form-label">C Name (COPY RIGHT)<span class="required">*</span> </label>
                                <input type="text" class="form-control" id="cname_basic" name="cname_basic" placeholder="Year with Company Name" value="{{ old('cname_basic', $release->cname ?? '') }}">
                                @if ($errors->has('cname_basic'))
                                    <div class="text-danger">
                                        {{ $errors->first('cname_basic') }}
                                    </div>
                                @endif
                            </div>
                            
                        </div>
                            
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="pname_basic" class="form-label">P Name (PUBLISHER)<span class="required">*</span> </label>
                                <input type="text" class="form-control" id="pname_basic" name="pname_basic" placeholder="Year with Company Name" value="{{ old('pname_basic', $release->pname ?? '') }}">
                                @if ($errors->has('pname_basic'))
                                    <div class="text-danger">
                                        {{ $errors->first('pname_basic') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <h5 class="siteTitle">Release Date info</h5>
                            </div>
                        </div>
                        

                        <div class="row">
                            <div class="col-6 mb-3">
                                <label for="original_release_date" class="form-label">Original Release Date<span class="required">*</span></label>
                                <input type="date" class="form-control" name="original_release_date" id="original_release_date" value="{{ old('original_release_date', $release->original_release_date) }}">
                                @if ($errors->has('original_release_date'))
                                    <div class="text-danger">
                                        {{ $errors->first('original_release_date') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6 mb-3">
                                <label for="sales_date" class="form-label">Sales Date<span class="required">*</span></label>
                                <input type="date" class="form-control" name="sales_date" id="sales_date" value="{{ old('sales_date', $release->sales_date) }}">
                                @if ($errors->has('sales_date'))
                                    <div class="text-danger">
                                        {{ $errors->first('sales_date') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="tab-pane fade  {{($level=='artwork')? ' show active':''}}" id="v-pills-artwork" role="tabpanel" aria-labelledby="v-pills-artwork-tab">
                        <h3 class="siteTitle">Artwork</h3>
                        <div class="row">
                            <div class="alert alert-danger artwork_error" style="display:none;">
                            </div>
                            @if ($errors->has('file'))
                                <div class="alert alert-danger artwork_error">
                                    {{ $errors->first('file') }}
                                </div>
                            @endif
                        </div>
                        <div class="row">
                                <div class="col-8 _artwork">
                                        <div class="card ">                            
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <form action="{{ route('releases.artwork.save') }}" method="POST" enctype="multipart/form-data"  id="dropzone-basic" class="dropzone">
                                                            @csrf
                                                            <input type="hidden" name="release_id" id="artwork_release_id" value="{{ $release->id }}">
                                                            <input type="hidden" name="summary" value="{{ $summary ?? '' }}">
                                                        </form>
                                                    </div>   
                                                </div>
                                            </div>
                                        </div>
                                
                                        @if (!empty($release->thumbnail_path))                  
                                        <div class="wrap_image">
                                            <img id="existing-thumbnail" src="{{ asset('storage/' . $release->thumbnail_path) }}" width="150px" alt="Thumbnail" >
                                        </div>
                                        @endif
                                        
                                </div>
                                <div class="col-4 artwork-instruction">

                                    <p><b>Your Image Must Be :</b></p>
                                    <p>TIF or JPG gormat</p>
                                    <p>Square</p>
                                    <p>Minimum size: 3000 x 3000 pixels.</p>
                                    <p>Maximum size: 6000 x 6000 pixels.</p>
                                    <p>RGB format</p>
                                    <p>Opaque</p>
                                    <p>If you are scanning a CD, remove product sticker and crop marks</p>
                               </div>
                               <div class="col-12"> 
                                    <a href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'uploadtrack'])}}" class="btn btn-primary mt-3">Next</a>
                                </div>
                        </div>

                    <!-- <form action="{{route('releases.artwork.save')}}" method="POST" enctype="multipart/form-data" class="dropzone needsclick" id="dropzone-basic">
                        @csrf
                        <h3>Artwork</h3>
                      <div class ="row">
                           <div class="col-7 col-6 artwork-area">
                                <label for="thumbnail" class="form-label">Upload Your Artwork*</label>
                                 <div id="droparea" class="droparea">
                                    <p>Drag and drop your artwork here or click to select a file.</p>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <input type="file" class="form-control" id="artworkimage" name="thumbnail" style="display: none;" />
                                <input type="hidden" name ="release_id" value="{{$release->id}}">
                                <div id="image-info" class="mt-2"></div>
                                <div id="image-preview" class="image-preview">
                                    @if(!empty($release->thumbnail_path))
                                        <img src="{{ asset('storage/' . $release->thumbnail_path) }}" width="150px" alt="Thumbnail">
                                    @endif
                                </div>
                             <div id="error-message" class="text-danger mt-2"></div>
                            </div> 
                       
                            <div class="col-5 artwork-instruction">
                                <p><b>Your Image Must Be :</b></p>
                                <p>TIF or JPG gormat</p>
                                <p>Square</p>
                                <p>Minimum size: 3000 x 3000 pixels.</p>
                                <p>Maximum size: 6000 x 6000 pixels.</p>
                                <p>RGB format</p>
                                <p>Opaque</p>
                                <p>If you are scanning a CD, remove product sticker and crop marks</p>

                            </div>
                        </div>
                         </div>
                        <button type="submit" class="btn btn-primary">Save & Next</button>
                    </form> -->

                </div>
           
                <div class="tab-pane fade {{($level=='uploadtrack')? ' show active':''}}" id="v-pills-uploadtrack" role="tabpanel" aria-labelledby="v-pills-uploadtrack-tab">
                     <h5 class="siteTitle">Upload Tracks</h5>
                  
                     <div class="col-12">
                        <div class="uploadTracks">
                            <ul>
                                <li><strong>Single</strong> : maximum 1 file.</li>
                                <li><strong>EP</strong> : maximum 5 files.</li>
                                <li><strong>Album</strong> : maximum 30 files.</li>
                            </ul>
                            <h5 class="card-header">Multiple</h5>
                            <div class="alert alert-danger track_upload_error" style="display:none;"></div>
                            <div class="alert alert-success track_upload_success" style="display:none;"></div>
                            <div class="card-body">
                                <form action="{{route('releases.uploadTrack.save')}}"  method="post" enctype="multipart/form-data" id="image-upload" class="dropzone">
                                    @csrf
                                    <input type="hidden" name ="release_id" id="release_id" value="{{$release->id}}">
                                    <input type="hidden" name="summary" value="{{ $summary ?? '' }}">
                                    <input type="hidden" name="release_format"  id="release_format" value="{{ $release->format}}">
                                </form>
                                <div class="row mt-5">
                    

                                <div class="col-12">
                                @if(!$release->tracks->isEmpty())                       
                                    @foreach($release->tracks as $index => $track)
                                        <div class="col-6 trackList">
                                            <div style="width: 60%;">
                                                <p><strong>Track {{ $index + 1 }}:</strong> {{ basename($track->track_path) }}</p>
                                            </div>
                                            <div style="width: 30%;">
                                                <audio controls style="width: 90%;">
                                                    <source src="{{ asset('storage/' . $track->track_path) }}" type="audio/mpeg">
                                                    Your browser does not support the audio element.
                                                </audio>
                                            </div>
                                            <div style="width: 10%;">
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('removetrack-form').submit();">Remove</a>
                                                <form id="removetrack-form" action="{{ route('releases.uploadTrack.remove') }}" method="POST" class="d-none">
                                                    @csrf
                                                    <input type="hidden" name ="release_id"  value="{{$release->id}}">
                                                    <input type="hidden" name ="fn" value="{{basename($track->track_path) }}">
                                                </form>

                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                                </div>
                                <div class="col-12">
                                    <div class="nextBTN">
                                        <a href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'edittrack'])}}" class="btn btn-primary mt-3">Next</a>
                                    </div>
                                </div>

                                </div>
                                
                            </div>
                        </div>
                    </div>
                 </div>

                 <div class="tab-pane fade {{($level=='edittrack')? ' show active':''}}" id="v-pills-edittrack" role="tabpanel"        aria-labelledby="v-pills-edittrack-tab">
                        <h5 class="siteTitle">Edit Tracks</h5>
                        @if (session('errors') && session('errors')->hasBag('edittrack'))
                            @if($release->format != 'single')
                                <div class="alert alert-danger">
                                    <strong>Alert:</strong> You have missed the some required fields, please check each track manually.
                                </div>
                            @endif    

                        @endif

                        @if($release->tracks->isEmpty())
                            <div class="alert alert-warning">
                                <strong>Tracks Missing:</strong> Please upload tracks to proceed with the release process.
                            </div>
                            @else
                            <form action="{{ route('releases.editTrack.save') }}" method="POST" enctype="multipart/form-data">
                            @csrf  
                            <input type="hidden" name ="release_id" value="{{$release->id}}">
                            <input type="hidden" name="summary" value="{{ $summary ?? '' }}">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            @foreach($release->tracks as $index => $track)
                                            <a class="nav-link {{ ($index == 0) ? 'active' : '' }}" id="v-pills-track{{ $index }}-tab" data-bs-toggle="pill" href="#v-pills-track{{ $index }}" role="tab" aria-controls="v-pills-track{{ $index }}" aria-selected="{{ ($index == 0) ? 'true' : 'false' }}">
                                                <span>{{ $index + 1 }}. </span> {{ basename($track->track_path) }}
                                                <span class="track-duration">{{ $track->track_duration }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-8">
                                        <div class="tab-content _tab-content" id="v-pills-tabContent">
                                            @foreach($release->tracks as $index => $track)
                                            <div class="tab-pane fade {{ ($index == 0) ? 'show active' : '' }}" id="v-pills-track{{ $index }}" role="tabpanel" aria-labelledby="v-pills-track{{ $index }}-tab">
                                                <h4 class="siteTitle">Track Info {{ $index+1}}</h4>
                                                    <input type="hidden" name="track_id[]" value="{{$track->id}}" />
                                                    <div class="wrapTracksList">
                                                    <div class="row mb-3">
                                                        <div class="col-6">
                                                            <label for="track_name{{ $index }}" class="form-label">Track Name <span class="required">*</span></label>
                                                            <?php
                                                                if ($release->format == 'single') {
                                                                    echo '<input type="text" class="form-control" id="track_name' . $index . '" name="track_name[]" value="' . $release->release_name . '">';
                                                                } else {
                                                                    echo '<input type="text" class="form-control" id="track_name' . $index . '" name="track_name[]" value="' . pathinfo(basename($track->track_path), PATHINFO_FILENAME) . '">';
                                                                }
                                                            ?>
                                                            @if ($errors->edittrack->has('track_name.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('track_name.' . $index) }}</div>
                                                            @endif
                                                        </div> 
                                                        <div class="col-6">
                                                            <label for="track_version{{ $index }}" class="form-label">Version</label>
                                                            @if(count($release->tracks) > 1)
                                                                <button type="button" class="apply_click click_btn">Apply All</button>
                                                            @endif
                                                            <input type="text" class="form-control input-track_version" data-name="track_version" id="track_version{{ $index }}" name="track_version[]" value="{{ old('track_version.'.$index, $track->track_version)  }}">
                                                            @if ($errors->edittrack->has('track_version.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('track_version.' . $index) }}</div>
                                                            @endif
                                                        </div>   
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-6 wrap-field">
                                                            <label for="lyrics_language" class="form-label">Lyrics Language<span class="required">*</span></label>
                                                            @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_select_click click_btn">Apply All</button>
                                                            @endif

                                                            <select class="form-control input-lyrics_language" data-name="lyrics_language" id="lyrics_language{{ $index }}" name="lyrics_language[]">
                                                                <option value="" disabled selected>Select a language</option>
                                                                @foreach($languages as $language)
                                                                    <option value="{{ $language->name }}" {{ old('lyrics_language.'.$index, $track->lyrics_language) == $language->name ? 'selected' : '' }}>
                                                                        {{ $language->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            @if ($errors->edittrack->has('lyrics_language.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('lyrics_language.' . $index) }}</div>
                                                            @endif

                                                        </div>
                                                        <div class="col-6 wrap-field">
                                                            <label for="explicit_content" class="form-label">Explicit Content<span class="required">*</span></label>
                                                            @if(count($release->tracks) > 1)
                                                                <button type="button" class="apply_radio_click click_btn">Apply All</button>
                                                            @endif
                                                            <div class="wrap-buttons">
                                                                <input type="radio" id="explicit_content_none_{{ $index }}" class="input-explicit" name="explicit_content[{{ $index }}]" value="none" 
                                                                    {{ (old('explicit_content.'.$index, $track->explicit_content) == 'none') ? 'checked' : '' }}>
                                                                <label for="explicit_content_none_{{ $index }}">None</label>
                                                                <input type="radio" id="explicit_content_explicit_{{ $index }}" class="input-explicit" name="explicit_content[{{ $index }}]" value="explicit" 
                                                                    {{ (old('explicit_content.'.$index, $track->explicit_content) == 'explicit') ? 'checked' : '' }}>
                                                                <label for="explicit_content_explicit_{{ $index }}">Explicit</label>
                                                                <input type="radio" id="explicit_content_clean_{{ $index }}" class="input-explicit" name="explicit_content[{{ $index }}]" value="clean" 
                                                                    {{ (old('explicit_content.'.$index, $track->explicit_content) == 'clean') ? 'checked' : '' }}>
                                                                <label for="explicit_content_clean_{{ $index }}">Clean</label>
                                                                @if ($errors->edittrack->has('explicit_content.' . $index))
                                                                        <div class="text-danger">{{ $errors->edittrack->first('explicit_content.' . $index) }}</div>
                                                                @endif
                                                            </div>
                                                        </div>   
                                                    </div>
                                                    
                                                    <div class="row mb-3"> 
                                                        <div class="col-12">
                                                             <h5 class="siteTitle">Contributor</h5>
                                                        </div>
                                                        <div class="col-6">
                                                            
                                                            <label for="primary_artist"  class="form-label">Primary Artist<span class="required">*</span></label>
                                                            @if(count($release->tracks) > 1)
                                                                <button type="button" class="apply_click click_btn">Apply All</button>
                                                            @endif
                                                            <input type="text" class="form-control input-primary_artist" data-name="primary_artist" id="primary_artist{{ $index }}" name="primary_artist[]" value ="{{old('primary_artist.'.$index,$track->track_primary_artist)}}"  >
                                                            @if ($errors->edittrack->has('primary_artist.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('primary_artist.' . $index) }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="featuring_artist"  class="form-label">Featuring Artist</label>
                                                            @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_click click_btn">Apply All</button>
                                                            @endif
                                                            <input type="text" class="form-control input-featuring_artist" data-name="featuring_artist" id="featuring_artist{{ $index }}" name="featuring_artist[]"  value ="{{old('featuring_artist.'.$index,$track->track_featuring_artist)}}" >
                                                            @if ($errors->edittrack->has('featuring_artist.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('featuring_artist.' . $index) }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3"> 
                                                        <div class="col-6">
                                                            <label for="track_remixer"  class="form-label">Remixer</label>
                                                            @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_click click_btn">Apply All</button>
                                                            @endif
                                                            <input type="text" class="form-control input-track_remixer" data-name="track_remixer" id="track_remixer{{ $index }}" name="track_remixer[]"   value ="{{old('track_remixer.'.$index, $track->track_remixer)}}" >
                                                            @if ($errors->edittrack->has('track_remixer.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('track_remixer.' . $index) }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="song_writer"  class="form-label">Song Writer<span class="required">*</span></label>
                                                            @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_click click_btn">Apply All</button>
                                                            @endif
                                                            <input type="text" class="form-control input-song_writer" data-name="song_writer" id="song_writer{{ $index }}" name="song_writer[]" value ="{{old('song_writer.'.$index, $track->song_writer)}}">
                                                            @if ($errors->edittrack->has('song_writer.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('song_writer.' . $index) }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3"> 
                                                        <div class="col-12">
                                                            <label for="track_producer"  class="form-label">Producer<span class="required">*</span></label>                                                      
                                                            @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_click click_btn">Apply All</button>
                                                            @endif
                                                            <input type="text" class="form-control input-track_producer" data-name="track_producer" id="track_producer{{ $index }}" name="track_producer[]"  value ="{{old('track_producer.'.$index,$track->track_producer)}}" >
                                                            @if ($errors->edittrack->has('track_producer.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('track_producer.' . $index) }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-12">
                                                            <h5 class="siteTitle">Composer</h5>
                                                        </div>
                                                        <div class="col-6">
                                                            
                                                            <label for="composer_name"  class="form-label">Composer Name<span class="required">*</span></label>
                                                            @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_click click_btn">Apply All</button>
                                                            @endif
                                                            <input type="text" class="form-control input-composer_name" data-name="composer_name" id="composer_name{{ $index }}" name="composer_name[]"  value ="{{old('composer_name.'.$index, $track->composer_name)}}" >
                                                            @if ($errors->edittrack->has('composer_name.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('composer_name.' . $index) }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="label_name"  class="form-label">Label Name<span class="required">*</span></label>
                                                            @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_click click_btn">Apply All</button>
                                                            @endif
                                                            <input type="text" class="form-control input-label_name" data-name="label_name" id="label_name{{ $index }}" name="label_name[]"  value ="{{old('label_name.'.$index, $track->track_label_name)}}" >
                                                            @if ($errors->edittrack->has('label_name.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('label_name.' . $index) }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                      
                                                        <div class="col-12">
                                                            <label for="isrc"  class="form-label">ISRC </label>
                                                            @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_click click_btn">Apply All</button>
                                                            @endif
                                                            <input type="text" class="form-control input-isrc" data-name="isrc" id="isrc{{ $index }}" name="isrc[]"  value ="{{old('isrc.'.$index, $track->isrc)}}" >
                                                            @if ($errors->edittrack->has('isrc.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('isrc.' . $index) }}</div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3">
                                                        <div class="col-12 wrap-field">
                                                            <label for="primary_performers"  class="form-label">Primary Performers<span class="required">*</span> </label>
                                                            <div class="wrap-checkbox">
                                                                <input type="checkbox" class="input-primary_performers" data-name="primary_performers" id="primary_performers{{$index}}" name="primary_performers[]" 
                                                                {{ (old('primary_performers.'.$index, $track->primary_performers) == $track->primary_performers) ? 'checked' : '' }}>
                                                                @if(count($release->tracks) > 1)
                                                                    <button type="button" class="apply_checkbox_click click_btn">Apply All</button>
                                                                @endif
                                                                @if ($errors->edittrack->has('primary_performers.' . $index))
                                                                    <div class="text-danger">{{ $errors->edittrack->first('primary_performers.' . $index) }}</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <h5 class="siteTitle">Master Right</h5>
                                                        </div>
                                                        <div class="col-6">
                                                            
                                                            <label for="pname"  class="form-label">P Name(PUBLISHER)<span class="required">*</span></label>
                                                            @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_click click_btn">Apply All</button>
                                                            @endif
                                                        
                                                            <input type="text" name="pname[]"  class="form-control input-pname" data-name="pname"  id="pname{{ $index }}" value="{{old('pname.'.$index, $track->pname)}}" />
                                                            @if ($errors->edittrack->has('pname.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('pname.' . $index) }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-6">
                                                            <label for="cname"  class="form-label">C Name(Copyright)<span class="required">*</span></label>
                                                            @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_click click_btn">Apply All</button>
                                                            @endif
                                                            <input type="text" name="cname[]" class="form-control input-cname" data-name="cname" id="cname{{ $index }}" value="{{old('cname.'.$index, $track->cname)}}"  />
                                                            @if ($errors->edittrack->has('cname.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('cname.' . $index) }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-6 wrap-field">
                                                            <label for="ownership_for_sound_rec"  class="form-label">Ownership for the sound recording<span class="required">*</span></label>
                                                            @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_select_click click_btn">Apply All</button>
                                                            @endif
                                                            <select name="ownership_for_sound_rec[]" class="form-control input-ownership_for_sound_rec" data-name="ownership_for_sound_rec" id="ownership_for_sound_rec{{ $index }}">
                                                                <option value="" disabled selected>Select Ownership Type</option>
                                                                @foreach($ownershiptypes as $ownershiptype)
                                                                    <option value="{{ $ownershiptype->name }}" {{ old('ownership_for_sound_rec.' . $index, $track->ownership_for_sound_rec) == $ownershiptype->name ? 'selected' : '' }}>
                                                                        {{ $ownershiptype->name }}
                                                                    </option>

                                                                @endforeach
                                                            </select>
                                                            @if ($errors->edittrack->has('ownership_for_sound_rec.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('ownership_for_sound_rec.' . $index) }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="col-6 wrap-field">
                                                            <label for="country_of_rec"  class="form-label">Country of recording<span class="required">*</span> </label>
                                                            @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_select_click click_btn">Apply All</button>
                                                            @endif
                                                            <select name="country_of_rec[]" class="form-control input-country_of_rec" data-name="country_of_rec" id="country_of_rec{{ $index }}">
                                                                <option value="" disabled selected>Select a country of recording</option>
                                                                @foreach($countries as $country)
                                                                    <option value="{{ $country->name }}" {{ old('country_of_rec.' . $index, $track->country_of_rec) == $country->name ? 'selected' : '' }}>
                                                                        {{ $country->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            @if ($errors->edittrack->has('country_of_rec.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('country_of_rec.' . $index) }}</div>
                                                            @endif
                                                        </div>
                                                    </div>

                                                 
                                                    <div class="row">
                                                      
                                                        <div class="col-6 wrap-field">
                                                            <label for="nationality" class="form-label">Nationality of original copyright owner<span class="required">*</span> </label>
                                                            @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_select_click click_btn">Apply All</button>
                                                            @endif
                                                            <select name="nationality[]" id="nationality{{ $index }}" class="form-control input-nationality" data-name="nationality">
                                                                <option value="" disabled selected>Select a nationality</option>
                                                                @foreach($countries as $country)
                                                                    <option value="{{ $country->name }}" {{ old('nationality.'.$index, $track->nationality) == $country->name ? 'selected' : '' }}>
                                                                        {{ $country->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>

                                                            @if ($errors->edittrack->has('nationality.' . $index))
                                                                <div class="text-danger">{{ $errors->edittrack->first('nationality.' . $index) }}</div>
                                                            @endif
                                                        </div>
                                                        </div>
                                                    </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                       @endif
                 </div>

                 <div class="tab-pane fade  {{($level=='platforms')? ' show active':''}}" id="v-pills-platforms" role="tabpanel" aria-labelledby="v-pills-platforms-tab">
                    <h3 class="siteTitle">Platforms</h3>
                    @if (session('errors') && session('errors')->hasBag('platforms'))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach (session('errors')->getBag('platforms')->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    <form  action="{{ route('releases.platforms.save') }}" method="POST">
                        @csrf
                        <div class="col-6 _platforms">
                            

                            <!-- <label class="form-label">Choose platforms</label> -->
                            <button type="button" id="toggle-select" class="btn btn-primary">Select All</button>
                            <input type="hidden" name="release_id" value="{{ $release->id }}">
                            <div class="row">
                                <!-- Platform checkboxes -->
                                @php
                                    // Decode the JSON string into an array or use an empty array if null
                                    $userPlatformIds = json_decode(Auth::user()->platform_id, true) ?? [];
                                @endphp

                                @foreach($platforms as $platform)
                                    @if(in_array($platform->id, $userPlatformIds))
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $platform->id }}" id="platform{{ $platform->id }}" name="platforms[]" 
                                                @if(in_array($platform->id, $release->platforms->pluck('id')->toArray())) checked @endif>
                                            <label class="form-check-label" for="platform{{ $platform->id }}">{{ $platform->name }}</label>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach
                            </div>

                        </div>

                        <div class="col-12">
                            <h5 class="siteTitle">Territories Configuration</h5>
                        </div>
                        <div class="col-6">
                            <label class="form-label">The release will be available worldwide</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="territoryOption" id="worldwide" value="worldwide" checked>
                                <label class="form-check-label" for="worldwide">worldwide</label>
                            </div>
                        </div>
                        <div class="col-12">
                           <div class="wrap-btn">
                                <button type="submit" class="btn btn-primary saveBtn">Save</button>
                           </div>
                        </div>
                    </form>

                </div>
                 <div class="tab-pane fade release_summary {{($level=='summary')? ' show active':''}}" id="v-pills-summary" role="tabpanel" aria-labelledby="v-pills-summary-tab">
                  <h2 class="siteTitle">Release Summary</h2>
             
                  @if($release->form_status)
                        <p class="text-danger">Note: If you want to make any changes to the release, please contact the administrator.</p>
                  @endif
                    <!-- Notice to complete all steps -->
                    <div class="alert alert-info mt-4">
                      Please ensure all steps are complete before clicking <strong>Submit Release.</strong>
                    </div>
                    <div class=" mt-2">
                        <div class="card mb-4">
                            <div class="card-body">
                                @php $status = 1; @endphp
                                @if(empty($release->meta_language))
                                    @php $status = 0; @endphp
                                    <div class="alert alert-warning">Basic Details Not Completed</div>
                                @else
                                    <h5 class="card-title">Basic Information</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>UPC:</strong> {{ $release->upc }}</p>
                                            <p><strong>Release Code:</strong> {{ $release->release_code ?? '' }}</p>
                                            <p><strong>Meta Language:</strong> {{ $release->meta_language ?? '' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Release Name:</strong> {{ $release->release_name ?? '' }}</p>
                                            <p><strong>Release Version:</strong> {{ $release->release_version ?? '' }}</p>
                                            <p><strong>Release Name Displayed As:</strong> {{ $release->release_name.'('.$release->release_version.')' }}</p>
                                        </div>
                                    </div>

                                    <h5 class="card-title mt-4">Artist & Contributor</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Primary Artist:</strong> {{ $release->primary_artist ?? '' }}</p>
                                            <p><strong>Featuring Artist:</strong> {{ $release->featuring_artist ?? '' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Remixer:</strong> {{ $release->remixer ?? '' }}</p>
                                            <p><strong>Producer:</strong> {{ $release->producer ?? '' }}</p>
                                        </div>
                                    </div>

                                    <h5 class="card-title mt-4">Release Details</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Genre:</strong> {{ $release->genre ?? '' }}</p>
                                            <p><strong>Sub Genre:</strong> {{ $release->sub_genre ?? '' }}</p>
                                            <p><strong>Format:</strong> {{ $release->format ?? '' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>C Name:</strong> {{ $release->cname ?? '' }}</p>
                                            <p><strong>P Name:</strong> {{ $release->pname ?? '' }}</p>
                                        </div>
                                    </div>

                                    <h5 class="card-title mt-4">Release Date Info</h5>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Original Release Date:</strong> {{ $release->original_release_date ?? '' }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Sales Date:</strong> {{ $release->sales_date ?? '' }}</p>
                                        </div>
                                    </div>

                                    <a href="{{ route('releases.step2', ['release_id' => $release->id, 'level' => 'basic', 'summary' => 'basic']) }}" class="btn btn-primary mt-4">Edit</a>
                                @endif
                            </div>
                        </div>


                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Artwork</h5>
                                @if(empty($release->thumbnail_path))
                                    @php $status =0; @endphp
                                    <div class="alert alert-warning">Thumbnail Not Completed</div>
                                @else
                                    <img src="{{ asset('storage/' . $release->thumbnail_path) }}" width="150px" alt="Thumbnail">
                                @endif
                                
                                <p><a href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'artwork', 'summary'=>'artwork'])}}" class="btn btn-primary mt-4">Edit</a></p>
                            </div>
                        </div>

                        <div class="card mb-4">
                           
                            <div class="card-body">
                                <h5 class="card-title">Uploaded Tracks</h5>
                                  @if($release->tracks->isEmpty())
                                       @php $status =0; @endphp
                                       <div class="alert alert-warning">Not Completed</div>
                                  @else
                                        @foreach($release->tracks as $index => $track)
                                            <div class="col-6">
                                                <p><strong>Track {{ $index + 1 }}:</strong> {{ basename($track->track_path) }}</p>
                                            </div>
                                        @endforeach
                                  @endif    
                                <a href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'uploadtrack','summary'=>'uploadtrack' ])}}" class="btn btn-primary mt-4">Edit</a>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Track Details</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            @if($release->tracks->isEmpty())
                                                 @php $status =0; @endphp
                                                <div class="alert alert-warning">Not Completed</div>
                                            @else
                                                @foreach($release->tracks as $index => $track)
                                                    <a class="nav-link {{ ($index == 0) ? 'active' : '' }}" id="v-pills-summary-track{{ $index }}-tab" data-bs-toggle="pill" href="#v-pills-summary-track{{ $index }}" role="tab" aria-controls="v-pills-summary-track{{ $index }}" aria-selected="{{ ($index == 0) ? 'true' : 'false' }}">
                                                        <span>{{$index+1}}</span> {{ basename($track->track_path) }}
                                                        <span class="track-duration">{{ $track->track_duration }}</span>
                                                    </a>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            @foreach($release->tracks as $index => $track)
                                                <div class="tab-pane fade {{ ($index == 0) ? 'show active' : '' }}" id="v-pills-summary-track{{ $index }}" role="tabpanel" aria-labelledby="v-pills-summary-track{{ $index }}-tab">
                                                    @if(empty($track->track_name))
                                                        <div class="alert alert-warning">Not Completed Track Details</div>
                                                    @else
                                                        <h4 class="siteTitle">Track Info {{ $index+1}}</h4>
                                                        <p><strong>Track Name:</strong> {{ pathinfo(basename($track->track_path), PATHINFO_FILENAME) }}</p>
                                                        <p><strong>Version:</strong> {{ $track->track_version }}</p>
                                                        <p><strong>Lyrics Language:</strong> {{ $track->lyrics_language }}</p>
                                                        <p><strong>Explicit Content:</strong> {{ $track->explicit_content }}</p>

                                                        <h5>Contributor</h5>
                                                        <p><strong>Primary Artist:</strong> {{$track->track_primary_artist }}</p>
                                                        <p><strong>Featuring Artist:</strong> {{ $track->track_featuring_artist }}</p>
                                                        <p><strong>Remixer:</strong> {{$track->track_remixer }}</p>
                                                        <p><strong>Song Writer:</strong> {{$track->song_writer }}</p>
                                                        <p><strong>Producer:</strong> {{ $track->track_producer }}</p>

                                                        <h5>Composer</h5>
                                                        <p><strong>Composer Name:</strong> {{ $track->composer_name }}</p>
                                                        <p><strong>Label Name:</strong> {{ $track->track_label_name }}</p>
                                                        <p><strong>ISRC:</strong> {{ $track->isrc }}</p>

                                                        <h5>Master Right</h5>
                                                        <p><strong>Primary Performers:</strong> {{ $track->track_performers }}</p>
                                                        <p><strong>Publisher Name:</strong> {{ $track->pname }}</p>
                                                        <p><strong>C Name:</strong> {{ $track->cname }}</p>
                                                        <p><strong>Ownership for the sound recording:</strong> {{ $track->ownership_for_sound_rec }}</p>
                                                        <p><strong>Country of Recording:</strong> {{$track->country_of_rec }}</p>
                                                        <p><strong>Nationality of Original Copyright Owner:</strong> {{ $track->nationality }}</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <a href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'edittrack', 'summary'=>'edittrack'])}}" class="btn btn-primary mt-4">Edit</a>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">PlatForms</h5>
                                @if($release->platforms->isEmpty())
                                   @php $status =0; @endphp
                                    <div class="alert alert-warning">Not Completed</div>
                                @else
                                    @foreach($release->platforms as $platform)
                                        <div class="col-6">
                                            <p>{{ $platform->name }}</p>
                                        </div>
                                    @endforeach
                                @endif
                                <a href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'platforms','summary'=>'platforms' ])}}" class="btn btn-primary mt-4">Edit</a>
                            </div>
                        </div>
                    </div>
                
                     
                        <form method="POST" action="{{ route('releases.final.release.submit') }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="release_id" value="{{$release->id}}" />
                            <input type="hidden" name="form_status" value="{{$status}}" />
                            <div class="submitBTN">
                                <button type="submit" class="btn btn-primary saveRelease">Submit Release</button>
                            </div>
                        </form>

              </div>
              @canany(['approve-release'])
              <div class="tab-pane fade {{($level=='control_release')? ' show active':''}}" id="v-pills-control_release" role="tabpanel" aria-labelledby="v-pills-control_release-tab">
                            <h5 class="siteTitle">Release Settings</h5>
                            <div class="col-12">
                                    <form method="POST" action="{{route('releases.status.update')}}" class="d-flex flex-column flex-sm-row align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group mb-2 mb-sm-0 mr-sm-3 flex-grow-1">
                                                <input type="hidden" name="release_id" value="{{$release->id}}" />
                                                <div class="wrap-inner">
                                                    <label for="status">Release Status</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="0" {{ $release->status == 0 ? 'selected' : '' }}>Pending</option>
                                                        <option value="1" {{ $release->status == 1 ? 'selected' : '' }}>Approved</option>
                                                        <option value="2" {{ $release->status == 2 ? 'selected' : '' }}>Rejected</option>
                                                    </select>
                                                </div>
                                                <div class="wrap-inner">
                                                    <label for="status">Editing Permissions</label>
                                                    <select class="form-control" id="form_status" name="form_status">
                                                        <option value="0" {{ $release->form_status == 0 ? 'selected' : '' }}>Enabled</option>
                                                        <option value="1" {{ $release->form_status == 1 ? 'selected' : '' }}>Disabled</option>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                </div>
                    
                           

                        </div>
                 @endcanany

        </div>
    </div>
</div>


@endsection

