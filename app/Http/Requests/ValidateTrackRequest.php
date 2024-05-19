<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateTrackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'track_name' => 'required|array',
            'track_name.*' => 'required|string|max:255|custom_index',
            'track_version' => 'required|array',
            'track_version.*' => 'required|string|max:50|custom_index',
            'lyrics_language' => 'required|array',
            'lyrics_language.*' => 'required|string|max:50|custom_index',
            'explicit_content' => 'required|array',
            'explicit_content.*' => 'required|string|max:50|custom_index',
            'primary_artist' => 'required|array',
            'primary_artist.*' => 'required|string|max:255|custom_index',
            'featuring_artist' => 'nullable|array',
            'featuring_artist.*' => 'nullable|string|max:255|custom_index',
            'track_remixer' => 'nullable|array',
            'track_remixer.*' => 'nullable|string|max:255|custom_index',
            'song_writer' => 'required|array',
            'song_writer.*' => 'required|string|max:255|custom_index',
            'track_producer' => 'required|array',
            'track_producer.*' => 'required|string|max:255|custom_index',
            'composer_name' => 'required|array',
            'composer_name.*' => 'required|string|max:255|custom_index',
            'label_name' => 'required|array',
            'label_name.*' => 'required|string|max:255|custom_index',
            'isrc' => 'required|array',
            'isrc.*' => 'required|string|max:255|custom_index',
            'primary_performers' => 'required|array',
            'primary_performers.*' => 'required|string|max:255|custom_index',
            'pname' => 'required|array',
            'pname.*' => 'required|string|max:255|custom_index',
            'cname' => 'required|array',
            'cname.*' => 'required|string|max:255|custom_index',
            'ownership_for_sound_rec' => 'required|array',
            'ownership_for_sound_rec.*' => 'required|string|max:255|custom_index',
            'country_of_rec' => 'required|array',
            'country_of_rec.*' => 'required|string|max:255|custom_index',
            'nationality' => 'required|array',
            'nationality.*' => 'required|string|max:255|custom_index',
        ];
    }
    public function messages()
    {
        return [
            'track_name.required' => 'Track names are required.',
            'track_name.*.required' => 'Each track name is required.',
            'track_version.required' => 'Track versions are required.',
            'track_version.*.required' => 'Each track version is required.',
            'lyrics_language.required' => 'Lyrics languages are required.',
            'lyrics_language.*.required' => 'Each lyrics language is required.',
            'explicit_content.required' => 'Explicit content is required.',
            'explicit_content.*.required' => 'Each explicit content field is required.',
            'primary_artist.required' => 'Primary artists are required.',
            'primary_artist.*.required' => 'Each primary artist is required.',
            'song_writer.required' => 'Song writers are required.',
            'song_writer.*.required' => 'Each song writer is required.',
            'track_producer.required' => 'Track producers are required.',
            'track_producer.*.required' => 'Each track producer is required.',
            'composer_name.required' => 'Composer names are required.',
            'composer_name.*.required' => 'Each composer name is required.',
            'label_name.required' => 'Label names are required.',
            'label_name.*.required' => 'Each label name is required.',
            'isrc.required' => 'ISRC codes are required.',
            'isrc.*.required' => 'Each ISRC code is required.',
            'primary_performers.required' => 'Primary performers are required.',
            'primary_performers.*.required' => 'Each primary performer is required.',
            'pname.required' => 'Publisher names are required.',
            'pname.*.required' => 'Each publisher name is required.',
            'cname.required' => 'Composer names are required.',
            'cname.*.required' => 'Each composer name is required.',
            'ownership_for_sound_rec.required' => 'Ownership for sound recording is required.',
            'ownership_for_sound_rec.*.required' => 'Each ownership for sound recording field is required.',
            'country_of_rec.required' => 'Country of recording is required.',
            'country_of_rec.*.required' => 'Each country of recording is required.',
            'nationality.required' => 'Nationalities are required.',
            'nationality.*.required' => 'Each nationality is required.',
        ];
    }
}
