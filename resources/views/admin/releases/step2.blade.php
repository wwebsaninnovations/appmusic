@extends('admin.layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3">
            <!-- Nav tabs -->
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="nav-link {{($level=='basic')? ' active':''}}" id="v-pills-basic-tab" data-bs-toggle="pill" data-bs-target="#v-pills-basic" type="button" role="tab" aria-controls="v-pills-basic" aria-selected="true">Basic</button>
                <button class="nav-link {{($level=='artwork')? ' active':''}}" id="v-pills-artwork-tab" data-bs-toggle="pill" data-bs-target="#v-pills-artwork" type="button" role="tab" aria-controls="v-pills-artwork" aria-selected="false">Artwork</button>
                <button class="nav-link {{($level=='uploadtrack')? ' active':''}}" id="v-pills-uploadtrack-tab" data-bs-toggle="pill" data-bs-target="#v-pills-uploadtrack" type="button" role="tab" aria-controls="v-pills-uploadtrack" aria-selected="false">Upload Track</button>
                <button class="nav-link {{($level=='edittrack')? ' active':''}}" id="v-pills-edittrack-tab" data-bs-toggle="pill" data-bs-target="#v-pills-edittrack" type="button" role="tab" aria-controls="v-pills-edittrack" aria-selected="false">Edit Track</button>
            </div>
        </div>
        <div class="col-md-9">
            <!-- Tab panes -->
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade  {{($level=='basic')? ' show active':''}}" id="v-pills-basic" role="tabpanel" aria-labelledby="v-pills-basic-tab">
                         <!-- Display validation errors -->
                         @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    <p>Complete Release Basic Information</p>
                    <form action="{{route('releases.basic.save')}}" method="POST">
                        @csrf
                       <div class="mb-3">
                            <label for="upc" class="form-label">UPC</label>
                            <input type="text" class="form-control" id="upc" name="upc" value="{{$release->upc}}">
                            <input type="hidden" name ="release_id" value="{{$release->id}}">
                        </div>
                        <div class="mb-3">
                            <label for="release_code" class="form-label">Release Code</label>
                            <input type="text" class="form-control" id="release_code" name="release_code" value="{{ $release->release_code}}">
                        </div>
                        <div class="mb-3">
                            <label for="release_code" class="form-label">Meta Language</label>
                            <select class="form-select" id="format" name="release_language">
                                <option value="">Select Language</option>
                                <option value="Hindi" {{ old('release_language') == 'Hindi' ? 'selected' : '' }}>Hindi</option>
                                <option value="English" {{ old('release_language') == 'English' ? 'selected' : '' }}>English</option>
                                <option value="Bhojpuri" {{ old('release_language') == 'Bhojpuri' ? 'selected' : '' }}>Bhojpuri</option>
                            </select>

                        </div>

                         <div class="mb-3">
                            <label for="release_name" class="form-label">Release Name</label>
                            <input type="text" class="form-control" id="release_name" name="release_name" value="{{$release->release_name }}">
                        </div>

                        <div class="mb-3">
                            <label for="release_version" class="form-label">Release Version</label>
                            <input type="text" class="form-control" id="release_version" name="release_version" value="{{$release->release_version}}">
                        </div>
                        <div class="mb-3">
                            <label for="release_name_displayed_as" class="form-label">Release Name Displayed As</label>
                            <input type="text" class="form-control" id="release_name_displayed_as" name="release_name_displayed_as" value="{{ $release->release_name . '(' .$release->release_version.')' }}">
                        </div>
                        <h5>Artist & Contributor</h5>
                        <div class="mb-3">
                            <label for="primary_artist" class="form-label">Primary Artist</label>
                            <input type="text" class="form-control" id="primary_artist" name="primary_artist" value="{{ old('primary_artist')}}">
                            <div>Suggestions and create new</div>
                        </div>
                        <div class="mb-3">
                            <label for="featuring_artist" class="form-label"> Featuring Artist</label>
                            <input type="text" class="form-control" id="featuring_artist" name="featuring_artist" value="{{ old('featuring_artist')}}">
                        </div>
                        <div class="mb-3">
                            <label for="featuring_artist" class="form-label">Remixer</label>
                            <input type="text" class="form-control" id="featuring_artist" name="featuring_artist" value="{{ old('featuring_artist')}}">
                        </div>
                        <div class="mb-3">
                            <label for="producer_artist" class="form-label">Producer</label>
                            <input type="text" class="form-control" id="producer_artist" name="producer_artist" value="{{ old('producer_artist')}}">
                        </div>
                        <p>Release Details</p>
                        <div class="mb-3">
                            <label for="genre" class="form-label">Genre*</label>
                            <select class="form-select" id="genre" name="genre">
                                <option value=''>Select Genre</option>
                                <option value='Pop' {{ old('genre') == 'Pop' ? 'selected' : '' }}>Pop</option>
                            </select>

                        </div>
                        <div class="mb-3">
                            <label for="sub_genre" class="form-label">Sub Genre</label>
                            <select class="form-select" id="sub_genre" name="sub_genre">
                                <option value=''>Select Sub Genre</option>
                                <option value="pop" {{ old('sub_genre') == 'pop' ? 'selected' : '' }}>Pop</option>
                            </select>
                        </div>
                                 
                        <div class="mb-3">
                            <label for="format" class="form-label">Format</label>
                            <select class="form-select" id="format" name="format">
                                <option value="">Select Format</option>
                                <option value="single" {{ ($release->format == 'single') ? 'selected' : '' }}>Single</option>
                                <option value="ep" {{($release->format == 'ep') ? 'selected' : '' }}>EP</option>
                                <option value="album" {{ ($release->format == 'album') ? 'selected' : '' }}>Album</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="cname" class="form-label">C Name</label>
                            <input type="text" class="form-control" id="cname" name="cname" placeholder ="Year with Company Name" value="{{ old('cname')}}">
                        </div>
                        <button type="submit" class="btn btn-primary">Save & Next</button>
                   </form>
                </div>

                <div class="tab-pane fade  {{($level=='artwork')? ' show active':''}}" id="v-pills-artwork" role="tabpanel" aria-labelledby="v-pills-artwork-tab">
                    <p>Artwork</p>
                    <form action="{{route('releases.artwork.save')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class ="row">
                            <div class=" col-5 mb-3">
                                <label for="thumbnail" class="form-label">Upload Your Artwork</label>
                                <input type="file" class="form-control" id="thumbnail" name="thumbnail" />
                                <input type="hidden" name ="release_id" value="{{$release->id}}">
                            </div>
                            <div class="col-7">
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
                        <button type="submit" class="btn btn-primary">Save & Next</button>
                    </form>
                </div>
           
                <div class="tab-pane fade {{($level=='uploadtrack')? ' show active':''}}" id="v-pills-uploadtrack" role="tabpanel" aria-labelledby="v-pills-uploadtrack-tab">
                     <p>Upload Tracks</p>
                     <form action="{{route('releases.uploadTrack.save')}}" method="POST" enctype="multipart/form-data">
                            @csrf  
                            <div class="mb-3">
                                <label for="tracks" class="form-label">Upload from Computer</label>
                                <input type="file" class="form-control" id="tracks" name="track_paths[]" multiple />
                                <input type="hidden" name ="release_id" value="{{$release->id}}">
                            </div>   
                            <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                 </div>

                 <div class="tab-pane fade {{($level=='edittrack')? ' show active':''}}" id="v-pills-edittrack" role="tabpanel" aria-labelledby="v-pills-edittrack-tab">
                    <p>Edit Tracks</p>
                    <ul class="track-list">
                        @foreach($tracks as $track)
                            <li class="track-item">
                                <span class="track-name">{{ basename($track->track_path) }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
        </div>
    </div>
</div>

@endsection
