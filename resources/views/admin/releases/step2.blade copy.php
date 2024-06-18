@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-2 tabs-item release-nav-link">
            <!-- Nav tabs -->
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link {{($level=='basic')? ' active':''}}" id="v-pills-basic-tab" data-bs-toggle="pill" href="#v-pills-basic" role="tab" aria-controls="v-pills-basic" aria-selected="true" data-href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'basic'])}}">Basic</a>
                <a class="nav-link {{($level=='artwork')? ' active':''}}" id="v-pills-artwork-tab" data-bs-toggle="pill" href="#v-pills-artwork" role="tab" aria-controls="v-pills-artwork" aria-selected="false" data-href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'artwork'])}}">Artwork</a>
                <a class="nav-link {{($level=='uploadtrack')? ' active':''}}" id="v-pills-uploadtrack-tab" data-bs-toggle="pill" href="#v-pills-uploadtrack" role="tab" aria-controls="v-pills-uploadtrack" aria-selected="false" data-href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'uploadtrack'])}}">Upload Track</a>
                <a class="nav-link {{($level=='edittrack')? ' active':''}}" id="v-pills-edittrack-tab" data-bs-toggle="pill" href="#v-pills-edittrack" role="tab" aria-controls="v-pills-edittrack" aria-selected="false" data-href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'edittrack'])}}">Edit Track</a>
                <a class="nav-link {{($level=='platforms')? ' active':''}}" id="v-pills-platforms-tab" data-bs-toggle="pill" href="#v-pills-platforms" role="tab" aria-controls="v-pills-edittrack" aria-selected="false" data-href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'platforms'])}}">Platforms-Configuration</a>
                <a class="nav-link {{($level=='summery')? ' active':''}}" id="v-pills-summery-tab" data-bs-toggle="pill" href="#v-pills-summery" role="tab" aria-controls="v-pills-summery" aria-selected="false" data-href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'summery'])}}">Summary</a>
            </div>
        </div>

        <div class="col-md-10">
          
            @if ($message = Session::get('success'))
                <div class="alert alert-success text-center" role="alert">
                    {{ $message }}
                </div>
            @endif
            <!-- Tab panes -->
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade  {{($level=='basic')? ' show active':''}}" id="v-pills-basic" role="tabpanel" aria-labelledby="v-pills-basic-tab">
                   
                    <h5>Complete Release Basic Information</h5>
                        <form action="{{ route('releases.basic.save') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="upc" class="form-label">UPC*</label>
                                <input type="text" class="form-control" id="upc" name="upc" value="{{ old('upc', $release->upc ?? '') }}">
                                @if ($errors->has('upc'))
                                    <div class="text-danger">
                                        {{ $errors->first('upc') }}
                                    </div>
                                @endif
                            </div>

                            <input type="hidden" name="release_id" value="{{ $release->id }}">
                            <input type="hidden" name="summary" value="{{ $summary ?? '' }}">

                            <div class="mb-3">
                                <label for="release_code" class="form-label">Release Code*</label>
                                <input type="text" class="form-control" id="release_code" name="release_code" value="{{ old('release_code', $release->release_code ?? '') }}">
                                @if ($errors->has('release_code'))
                                    <div class="text-danger">
                                        {{ $errors->first('release_code') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="meta_language" class="form-label">Meta Language*</label>
                                <select class="form-select" id="meta_language" name="meta_language">
                                    <option value="">Select Language</option>
                                    <option value="Hindi" {{ old('meta_language', $release->meta_language) == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                                    <option value="English" {{ old('meta_language', $release->meta_language) == 'English' ? 'selected' : '' }}>English</option>
                                    <option value="Bhojpuri" {{ old('meta_language', $release->meta_language) == 'Bhojpuri' ? 'selected' : '' }}>Bhojpuri</option>
                                </select>
                                @if ($errors->has('meta_language'))
                                    <div class="text-danger">
                                        {{ $errors->first('meta_language') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="release_name" class="form-label">Release Name*</label>
                                <input type="text" class="form-control" id="release_name" name="release_name" value="{{ old('release_name', $release->release_name ?? '') }}">
                                @if ($errors->has('release_name'))
                                    <div class="text-danger">
                                        {{ $errors->first('release_name') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="release_version" class="form-label">Release Version*</label>
                                <input type="text" class="form-control" id="release_version" name="release_version" value="{{ old('release_version', $release->release_version ?? '') }}">
                                @if ($errors->has('release_version'))
                                    <div class="text-danger">
                                        {{ $errors->first('release_version') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="release_name_displayed_as" class="form-label">Release Name Displayed As</label>
                                <input type="text" class="form-control" id="release_name_displayed_as" name="release_name_displayed_as" value="{{ $release->release_name.'('.$release->release_version.')' }}">
                            </div>

                            <h5>Artist & Contributor</h5>

                            <div class="mb-3">
                                <label for="primary_artist_basic" class="form-label">Primary Artist*</label>
                                <input type="text" class="form-control" id="primary_artist_basic" name="primary_artist_basic" value="{{ old('primary_artist_basic', $release->primary_artist ?? '') }}">
                                @if ($errors->has('primary_artist_basic'))
                                    <div class="text-danger">
                                        {{ $errors->first('primary_artist_basic') }}
                                    </div>
                                @endif
                                <div>Suggestions and create new</div>
                            </div>

                            <div class="mb-3">
                                <label for="featuring_artist_basic" class="form-label">Featuring Artist*</label>
                                <input type="text" class="form-control" id="featuring_artist_basic" name="featuring_artist_basic" value="{{ old('featuring_artist_basic', $release->featuring_artist ?? '') }}">
                                @if ($errors->has('featuring_artist_basic'))
                                    <div class="text-danger">
                                        {{ $errors->first('featuring_artist_basic') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="remixer_artist_basic" class="form-label">Remixer*</label>
                                <input type="text" class="form-control" id="remixer_artist_basic" name="remixer_artist_basic" value="{{ old('remixer_artist_basic', $release->remixer ?? '') }}">
                                @if ($errors->has('remixer_artist_basic'))
                                    <div class="text-danger">
                                        {{ $errors->first('remixer_artist_basic') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="producer_artist_basic" class="form-label">Producer*</label>
                                <input type="text" class="form-control" id="producer_artist_basic" name="producer_artist_basic" value="{{ old('producer_artist_basic', $release->producer ?? '') }}">
                                @if ($errors->has('producer_artist_basic'))
                                    <div class="text-danger">
                                        {{ $errors->first('producer_artist_basic') }}
                                    </div>
                                @endif
                            </div>

                            <h5>Release Details</h5>

                            <div class="mb-3">
                                <label for="genre" class="form-label">Genre*</label>
                                <select class="form-select" id="genre" name="genre">
                                    <option value="">Select Genre</option>
                                    <option value="pop" {{ old('genre', $release->genre) == 'pop' ? 'selected' : '' }}>Pop</option>
                                    <!-- Add additional genres as needed -->
                                </select>
                                @if ($errors->has('genre'))
                                    <div class="text-danger">
                                        {{ $errors->first('genre') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="sub_genre" class="form-label">Sub Genre*</label>
                                <select class="form-select" id="sub_genre" name="sub_genre">
                                    <option value="">Select Sub Genre</option>
                                    <option value="pop" {{ old('sub_genre', $release->sub_genre) == 'pop' ? 'selected' : '' }}>Pop</option>
                                </select>
                                @if ($errors->has('sub_genre'))
                                    <div class="text-danger">
                                        {{ $errors->first('sub_genre') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="format" class="form-label">Format*</label>
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

                            <div class="mb-3">
                                <label for="cname_basic" class="form-label">C Name*</label>
                                <input type="text" class="form-control" id="cname_basic" name="cname_basic" placeholder="Year with Company Name" value="{{ old('cname_basic', $release->cname ?? '') }}">
                                @if ($errors->has('cname_basic'))
                                    <div class="text-danger">
                                        {{ $errors->first('cname_basic') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="pname_basic" class="form-label">P Name*</label>
                                <input type="text" class="form-control" id="pname_basic" name="pname_basic" placeholder="Year with Company Name" value="{{ old('pname_basic', $release->pname ?? '') }}">
                                @if ($errors->has('pname_basic'))
                                    <div class="text-danger">
                                        {{ $errors->first('pname_basic') }}
                                    </div>
                                @endif
                            </div>

                            <h5>Release Date info</h5>

                            <div class="mb-3">
                                <label for="original_release_date" class="form-label">Original Release Date*</label>
                                <input type="date" class="form-control" name="original_release_date" value="{{ old('original_release_date', $release->original_release_date) }}">
                                @if ($errors->has('original_release_date'))
                                    <div class="text-danger">
                                        {{ $errors->first('original_release_date') }}
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="sales_date" class="form-label">Sales Date*</label>
                                <input type="date" class="form-control" name="sales_date" value="{{ old('sales_date', $release->sales_date) }}">
                                @if ($errors->has('sales_date'))
                                    <div class="text-danger">
                                        {{ $errors->first('sales_date') }}
                                    </div>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Save & Next</button>
                        </form>
                </div>

                <div class="tab-pane fade  {{($level=='artwork')? ' show active':''}}" id="v-pills-artwork" role="tabpanel" aria-labelledby="v-pills-artwork-tab">
                        <h3>Artwork</h3>
                        <div class="row">
                             <!-- Display general error message -->
                                @if ($errors->has('file'))
                                    <div class="alert alert-danger">
                                        {{ $errors->first('file') }}
                                    </div>
                                @endif
                            <!-- Basic  -->
                                <div class="col-6">
                                        <div class="card">                            
                                                <div class="card-body">
                                                    <form action="{{ route('releases.artwork.save') }}" method="POST" enctype="multipart/form-data" class="dropzone needsclick" id="dropzone-basic">
                                                        @csrf
                                                        <div class="dz-message needsclick">
                                                            Drop files here or click to upload
                                                            <span class="note needsclick">(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</span>
                                                        </div>
                                                        <div class="fallback">
                                                            <input type="file" name="file"/>
                                                        </div>
                                                        <input type="hidden" name="release_id" value="{{ $release->id }}">
                                                        <input type="hidden" name="summary" value="{{ $summary ?? '' }}">
                                                        <input type="hidden"  name="thumbnail" id="artworkimge" style="display:none;">
                                                        <input type="hidden"  name="filename" id="artworkfilename" style="display:none;">
                                                        <div id="image-preview" class="image-preview">
                                                            @if (!empty($release->thumbnail_path))
                                                                <img id="existing-thumbnail" src="{{ asset('storage/' . $release->thumbnail_path) }}" width="150px" alt="Thumbnail" style="display: none;">
                                                            @endif
                                                        </div>
                                                        <div id="error-message" class="text-danger mt-2"></div>

                                                        <button type="submit" class="btn btn-primary">Save & Next</button>
                                                    </form>
                                            
                                                </div>
                                        </div>
                                </div>
                                <div class="col-6 artwork-instruction">

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

                    <!-- <form action="{{route('releases.artwork.save')}}" method="POST" enctype="multipart/form-data" class="dropzone needsclick" id="dropzone-basic">
                        @csrf
                        <h3>Artwork</h3>
                      <div class ="row">
                           <div class="col-7 mb-3 artwork-area">
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
                     <h5>Upload Tracks</h5>
               
                        @if ($errors->has('track_paths'))
                            <div class="alert alert-danger">
                                {{ $errors->first('track_paths') }}
                            </div>
                        @endif
                     <form action="{{route('releases.uploadTrack.save')}}" method="POST" enctype="multipart/form-data">
                            @csrf  
                            <div class="mb-3">
                                <label for="tracks" class="form-label">Upload from Computer*</label>
                                <input type="file" class="form-control" id="tracks" name="track_paths[]" multiple />
                                <input type="hidden" name ="release_id" value="{{$release->id}}">
                                <input type="hidden" name="summary" value="{{ $summary ?? '' }}">
                            </div>  
                          
                            @if(!$release->tracks->isEmpty())                       
                                @foreach($release->tracks as $index => $track)
                                    <div class="mb-3">
                                        <p><strong>Track {{ $index + 1 }}:</strong> {{ basename($track->track_path) }}</p>
                                        
                                        <audio controls>
                                            <source src="{{ asset('storage/' . $track->track_path) }}" type="audio/mpeg">
                                            Your browser does not support the audio element.
                                        </audio>
                                    </div>
                                @endforeach
                            @endif
                            <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                 </div>

                 <div class="tab-pane fade {{($level=='edittrack')? ' show active':''}}" id="v-pills-edittrack" role="tabpanel"        aria-labelledby="v-pills-edittrack-tab">
                        <h5>Edit Tracks</h5>
                        @if (session('errors') && session('errors')->hasBag('edittrack'))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach (session('errors')->getBag('edittrack')->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
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
                                    <div class="col-6">
                                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                            @foreach($release->tracks as $index => $track)
                                            <a class="nav-link {{ ($index == 0) ? 'active' : '' }}" id="v-pills-track{{ $index }}-tab" data-bs-toggle="pill" href="#v-pills-track{{ $index }}" role="tab" aria-controls="v-pills-track{{ $index }}" aria-selected="{{ ($index == 0) ? 'true' : 'false' }}">
                                                <span>{{ $index + 1 }}</span> {{ basename($track->track_path) }}
                                                <span class="track-duration">{{ $track->track_duration }}</span>
                                            </a>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            @foreach($release->tracks as $index => $track)
                                            <div class="tab-pane fade {{ ($index == 0) ? 'show active' : '' }}" id="v-pills-track{{ $index }}" role="tabpanel" aria-labelledby="v-pills-track{{ $index }}-tab">
                                                <h4>Track Info {{ $index+1}}</h4>
                                                    <input type="hidden" name="track_id[]" value="{{$track->id}}" />
                                                    <div class="mb-3">
                                                        <label for="track_name{{ $index }}" class="form-label">Track Name*</label>
                                                        <input type="text" class="form-control" id="track_name{{ $index }}" name="track_name[]" value="{{ pathinfo(basename($track->track_path), PATHINFO_FILENAME) }}">
                                                    </div> 
                                                    <div class="mb-3">
                                                        <label for="track_version{{ $index }}" class="form-label">Version*</label>
                                                        @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_click click_btn" style="display: block;">Apply Now</button>
                                                        @endif
                                                        <input type="text" class="form-control input-track_version" data-name="track_version" id="track_version{{ $index }}" name="track_version[]" value="{{ old('track_version.'.$index, $track->track_version)  }}">
                                                    </div>   
                                                    <div class="mb-3">
                                                        <label for="lyrics_language" class="form-label">Lyrics Language*</label>
                                                        @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_click click_btn" style="display: block;">Apply Now</button>
                                                        @endif
                                                        <input type="text" class="form-control input-lyrics_language" data-name="lyrics_language" id="lyrics_language{{ $index }}" name="lyrics_language[]" value="{{ old('lyrics_language.'.$index,$track->lyrics_language) }}">
                                                    </div>
                                                    <div class="mb-3 wrap-field">
                                                    <label for="explicit_content" class="form-label">Explicit Content*</label>

                                                       @if(count($release->tracks) > 1)
                                                          <button type="button" class="apply_radio_click click_btn">Apply Now</button>
                                                        @endif
                                                
                                                    <input type="radio" id="explicit_content_none_{{ $index }}" class="input-explicit" name="explicit_content[{{ $index }}]" value="none" 
                                                        {{ (old('explicit_content.'.$index, $track->explicit_content) == 'none') ? 'checked' : '' }}>
                                                    <label for="explicit_content_none_{{ $index }}">None</label>

                                                    <input type="radio" id="explicit_content_explicit_{{ $index }}" class="input-explicit" name="explicit_content[{{ $index }}]" value="explicit" 
                                                        {{ (old('explicit_content.'.$index, $track->explicit_content) == 'explicit') ? 'checked' : '' }}>
                                                    <label for="explicit_content_explicit_{{ $index }}">Explicit</label>

                                                    <input type="radio" id="explicit_content_clean_{{ $index }}" class="input-explicit" name="explicit_content[{{ $index }}]" value="clean" 
                                                        {{ (old('explicit_content.'.$index, $track->explicit_content) == 'clean') ? 'checked' : '' }}>
                                                    <label for="explicit_content_clean_{{ $index }}">Clean</label>


                                                    </div>   
                                                    <h5>Contributor</h5>
                                                    <div class="mb-3">
                                                        <label for="primary_artist"  class="form-label">Primary Artist*</label>
                                                        @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_click click_btn">Apply Now</button>
                                                        @endif
                                                        
                                                        <input type="text" class="form-control input-primary_artist" data-name="primary_artist" id="primary_artist{{ $index }}" name="primary_artist[]" value ="{{old('primary_artist.'.$index,$track->track_primary_artist)}}"  >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="featuring_artist"  class="form-label">Featuring Artist*</label>
                                                        
                                                        @if(count($release->tracks) > 1)
                                                          <button type="button" class="apply_click click_btn">Apply Now</button>
                                                        @endif
                                                        <input type="text" class="form-control input-featuring_artist" data-name="featuring_artist" id="featuring_artist{{ $index }}" name="featuring_artist[]"  value ="{{old('featuring_artist.'.$index,$track->track_featuring_artist)}}" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="track_remixer"  class="form-label">Remixer*</label>
                                                        @if(count($release->tracks) > 1)
                                                          <button type="button" class="apply_click click_btn">Apply Now</button>
                                                        @endif
                                                        <input type="text" class="form-control input-track_remixer" data-name="track_remixer" id="track_remixer{{ $index }}" name="track_remixer[]"   value ="{{old('track_remixer.'.$index, $track->track_remixer)}}" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="song_writer"  class="form-label">Song Writer*</label>
                                                        
                                                        @if(count($release->tracks) > 1)
                                                          <button type="button" class="apply_click click_btn">Apply Now</button>
                                                        @endif
                                                        <input type="text" class="form-control input-song_writer" data-name="song_writer" id="song_writer{{ $index }}" name="song_writer[]" value ="{{old('song_writer.'.$index, $track->song_writer)}}">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="track_producer"  class="form-label">Producer*</label>                                                      
                                                        @if(count($release->tracks) > 1)
                                                          <button type="button" class="apply_click click_btn">Apply Now</button>
                                                        @endif
                                                        <input type="text" class="form-control input-track_producer" data-name="track_producer" id="track_producer{{ $index }}" name="track_producer[]"  value ="{{old('track_producer.'.$index,$track->track_producer)}}" >
                                                    </div>
                                                    <h5>Composer</h5>
                                                    <div class="mb-3">
                                                        <label for="composer_name"  class="form-label">Composer Name*</label>
                                                        @if(count($release->tracks) > 1)
                                                          <button type="button" class="apply_click click_btn">Apply Now</button>
                                                        @endif
                                                        <input type="text" class="form-control input-composer_name" data-name="composer_name" id="composer_name{{ $index }}" name="composer_name[]"  value ="{{old('composer_name.'.$index, $track->composer_name)}}" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="label_name"  class="form-label">Label Name*</label>
                                                        @if(count($release->tracks) > 1)
                                                          <button type="button" class="apply_click click_btn">Apply Now</button>
                                                        @endif
                                                        <input type="text" class="form-control input-label_name" data-name="label_name" id="label_name{{ $index }}" name="label_name[]"  value ="{{old('label_name.'.$index, $track->track_label_name)}}" >
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="isrc"  class="form-label">ISRC* </label>
                                                        @if(count($release->tracks) > 1)
                                                          <button type="button" class="apply_click click_btn">Apply Now</button>
                                                        @endif
                                                        <input type="text" class="form-control input-isrc" data-name="isrc" id="isrc{{ $index }}" name="isrc[]"  value ="{{old('isrc.'.$index, $track->isrc)}}" >
                                                    </div>

                                                    <div class="mb-3 wrap-field">
                                                        <label for="primary_performers"  class="form-label">Primary Performers* </label>
                                                        <input type="checkbox" class="input-primary_performers" data-name="primary_performers" id="primary_performers{{$index}}" name="primary_performers[]" 
                                                         {{ (old('primary_performers.'.$index, $track->primary_performers) == $track->primary_performers) ? 'checked' : '' }}>
                                                         @if(count($release->tracks) > 1)
                                                            <button type="button" class="apply_checkbox_click click_btn">Apply Now</button>
                                                        @endif
                                                        
                                                    
                                                    </div>
                                                    <h5>Master Right</h5>
                                                    <div class="mb-3">
                                                        <label for="pname"  class="form-label">Publisher Name* </label>
                                                        @if(count($release->tracks) > 1)
                                                          <button type="button" class="apply_click click_btn">Apply Now</button>
                                                        @endif
                                                      
                                                        <input type="text" name="pname[]"  class="form-control input-pname" data-name="pname"  id="pname{{ $index }}" value="{{old('pname.'.$index, $track->pname)}}" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="cname"  class="form-label">C Name* </label>
                                                        @if(count($release->tracks) > 1)
                                                          <button type="button" class="apply_click click_btn">Apply Now</button>
                                                        @endif
                                                        <input type="text" name="cname[]" class="form-control input-cname" data-name="cname" id="cname{{ $index }}" value="{{old('cname.'.$index, $track->cname)}}"  />
                                                    </div>
                                                    <div class="mb-3 wrap-field">
                                                        <label for="ownership_for_sound_rec"  class="form-label">Ownership for the sound recording* </label>
                                                        @if(count($release->tracks) > 1)
                                                          <button type="button" class="apply_select_click click_btn">Apply Now</button>
                                                        @endif
                                                        
                                                        <select name="ownership_for_sound_rec[]" class="form-control input-ownership_for_sound_rec" data-name="ownership_for_sound_rec" id="ownership_for_sound_rec{{ $index }}">
                                                            <option value="I am the owner" {{ old('ownership_for_sound_rec.'.$index, $track->ownership_for_sound_rec) == 'I am the owner' ? 'selected' : '' }}>I am the owner</option>
                                                            <option value="I am the manager" {{ old('ownership_for_sound_rec.'.$index, $track->ownership_for_sound_rec) == 'I am the manager' ? 'selected' : '' }}>I am the manager</option>
                                                        </select>


                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="country_of_rec"  class="form-label">Country of recording* </label>
                                                        @if(count($release->tracks) > 1)
                                                          <button type="button" class="apply_click click_btn">Apply Now</button>
                                                        @endif
                                                      
                                                        <input type="text" class="form-control input-country_of_rec" data-name="country_of_rec"  id="country_of_rec{{ $index }}" name="country_of_rec[]" value="{{old('country_of_rec.'.$index, $track->country_of_rec)}}" />
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="nationality" class="form-label">Nationality of original copyright owner* </label>
                                                        @if(count($release->tracks) > 1)
                                                          <button type="button" class="apply_click click_btn">Apply Now</button>
                                                        @endif
                                                        <input type="text" name="nationality[]"  class="form-control input-nationality" data-name="nationality"  id="nationality{{ $index }}"   value="{{old('nationality.'.$index, $track->nationality)}}" />
                                                    </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Release</button>
                            </form>
                       @endif
                 </div>

                 <div class="tab-pane fade  {{($level=='platforms')? ' show active':''}}" id="v-pills-platforms" role="tabpanel" aria-labelledby="v-pills-platforms-tab">
                    <h2>Platforms</h2>
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
                        <div class="mb-3">
                        <label class="form-label">Choose platforms</label>
                        <input type="hidden" name="release_id" value="{{ $release->id }}">
                        <div class="row">
                            <!-- Platform checkboxes -->
                            @foreach($platforms as $platform)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $platform->id }}" id="platform{{ $platform->id }}" name="platforms[]" 
                                            @if(in_array($platform->id, $release->platforms->pluck('id')->toArray())) checked @endif>
                                        <label class="form-check-label" for="platform{{ $platform->id }}">{{ $platform->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        </div>

                        <h3>Territories Configuration</h3>
                        <div class="mb-3">
                            <label class="form-label">The release will be available worldwide</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="territoryOption" id="worldwide" value="worldwide" checked>
                                <label class="form-check-label" for="worldwide">worldwide</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Next</button>
                    </form>

                </div>
                 <div class="tab-pane fade release_summary {{($level=='summery')? ' show active':''}}" id="v-pills-summery" role="tabpanel" aria-labelledby="v-pills-summery-tab">
                    <div class="container mt-5">
                        <h2>Release Summary</h2>

                        <div class="card mb-4">
                            <div class="card-body">
                                @if(empty($release->upc))
                                    <div class="alert alert-warning">Basic Details Not Completed</div>
                                @else
                                    <h5 class="card-title">Basic Information</h5>
                                    <p><strong>UPC:</strong> {{ $release->upc }}</p>
                                    <p><strong>Release Code:</strong> {{ $release->release_code ?? '' }}</p>
                                    <p><strong>Meta Language:</strong> {{ $release->meta_language ?? '' }}</p>
                                    <p><strong>Release Name:</strong> {{ $release->release_name ?? '' }}</p>
                                    <p><strong>Release Version:</strong> {{ $release->release_version ?? '' }}</p>
                                    <p><strong>Release Name Displayed As:</strong> {{ $release->release_name.'('.$release->release_version.')' }}</p>

                                    <h5 class="card-title mt-4">Artist & Contributor</h5>
                                    <p><strong>Primary Artist:</strong> {{ $release->primary_artist ?? '' }}</p>
                                    <p><strong>Featuring Artist:</strong> {{ $release->featuring_artist ?? '' }}</p>
                                    <p><strong>Remixer:</strong> {{ $release->remixer ?? '' }}</p>
                                    <p><strong>Producer:</strong> {{ $release->producer ?? '' }}</p>

                                    <h5 class="card-title mt-4">Release Details</h5>
                                    <p><strong>Genre:</strong> {{ $release->genre ?? '' }}</p>
                                    <p><strong>Sub Genre:</strong> {{ $release->sub_genre ?? '' }}</p>
                                    <p><strong>Format:</strong> {{ $release->format ?? '' }}</p>
                                    <p><strong>C Name:</strong> {{ $release->cname ?? '' }}</p>
                                    <p><strong>P Name:</strong> {{ $release->pname ?? '' }}</p>

                                    <h5 class="card-title mt-4">Release Date Info</h5>
                                    <p><strong>Original Release Date:</strong> {{ $release->original_release_date ?? '' }}</p>
                                    <p><strong>Sales Date:</strong> {{ $release->sales_date ?? '' }}</p>

                                    <a href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'basic', 'summary'=>'basic' ])}}" class="btn btn-primary mt-4">Edit</a>
                                @endif
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Artwork</h5>
                                @if(empty($release->thumbnail_path))
                                    <div class="alert alert-warning">Thumbnail Not Completed</div>
                                @else
                                    <img src="{{ asset('storage/' . $release->thumbnail_path) }}" width="150px" alt="Thumbnail">
                                @endif
                                <p><strong>Artwork Instructions:</strong></p>
                                <ul>
                                    <li>TIF or JPG format</li>
                                    <li>Square</li>
                                    <li>Minimum size: 3000 x 3000 pixels</li>
                                    <li>Maximum size: 6000 x 6000 pixels</li>
                                    <li>RGB format</li>
                                    <li>Opaque</li>
                                    <li>If you are scanning a CD, remove product sticker and crop marks</li>
                                </ul>

                                <a href="{{route('releases.step2',['release_id'=>$release->id, 'level'=>'artwork', 'summary'=>'artwork'])}}" class="btn btn-primary mt-4">Edit</a>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Uploaded Tracks</h5>
                                  @if($release->tracks->isEmpty())
                                       <div class="alert alert-warning">Not Completed</div>
                                  @else
                                        @foreach($release->tracks as $index => $track)
                                            <div class="mb-3">
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
                                                        <h4>Track Info {{ $index+1}}</h4>
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
                    </div>
              </div>
        </div>
    </div>
</div>


@endsection

