/**
 * File Upload
 */

// 'use strict';

(function () {
  // previewTemplate: Updated Dropzone default previewTemplate
  // ! Don't change it unless you really know what you are doing
  const previewTemplate = `<div class="dz-preview dz-file-preview">
<div class="dz-details">
  <div class="dz-thumbnail">
    <img data-dz-thumbnail>
    <span class="dz-nopreview">No preview</span>
    <div class="dz-success-mark"></div>
    <div class="dz-error-mark"></div>
    <div class="dz-error-message"><span data-dz-errormessage></span></div>
    <div class="progress">
      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
    </div>
  </div>
  <div class="dz-filename" data-dz-name></div>
  <div class="dz-size" data-dz-size></div>
</div>
</div>`;

  // ? Start your code from here

  // Basic Dropzone
  // --------------------------------------------------------------------

// Initialize Dropzone
const myDropzone = new Dropzone('#dropzone-basic', {
  previewTemplate: previewTemplate,
  parallelUploads: 1,
  maxFilesize: 5, // Maximum file size for new uploads (in MB)
  addRemoveLinks: true,
  maxFiles: 1,
  acceptedFiles: 'image/jpeg, image/jpg, image/tiff, image/tif', // Specify accepted file types
  init: function() {
    const existingThumbnail = document.getElementById('existing-thumbnail');
    const thumbnailInput = document.getElementById('artworkimge');
    const filenameInput = document.getElementById('artworkfilename');
    
    if (existingThumbnail) {
      // Construct the filename with path and mime type
      const thumbnailPath = existingThumbnail.src;
      const filePathParts = thumbnailPath.split('/');
      const fileName = filePathParts[filePathParts.length - 1];
      const mimeType = 'image/' + fileName.split('.').pop(); // Assuming the file extension matches the mime type

      const mockFile = { name: `${fileName}`, size: 12345, type: mimeType };
      this.emit("addedfile", mockFile);
      this.emit("thumbnail", mockFile, existingThumbnail.src);
      this.emit("complete", mockFile);
      this.files.push(mockFile);
      existingThumbnail.style.display = 'none'; // Hide the existing thumbnail image element

      if (filenameInput) {
        filenameInput.value = fileName;
      }
    }

    // Event listener for when a file is added
    this.on("addedfile", function(file) {
      if (thumbnailInput) {
        const reader = new FileReader();
        reader.onload = function(event) {
          thumbnailInput.value = event.target.result;
        };
        reader.readAsDataURL(file);
      }
      if (filenameInput) {
        filenameInput.value = file.name;
      }
    });

    // Event listener for when a file is removed
    this.on("removedfile", function(file) {
      console.log("File removed:", file);
      if (thumbnailInput) {
        thumbnailInput.value = '';
      }
      if (filenameInput) {
        filenameInput.value = '';
      }
    });
  }
});


  // Multiple Dropzone
  // --------------------------------------------------------------------
  const dropzoneMulti = new Dropzone('#dropzone-multi', {
   // previewTemplate: previewTemplate,
  //  parallelUploads: 1,
    maxFilesize: 5,
    addRemoveLinks: true
  });

})();
