

<style>
    
@media (min-width: 1200px) {
  body .tutor-container-xxl,
  body .tutor-container-xl,
  body .tutor-container-lg,
  body .tutor-container-md,
  body .tutor-container-sm,
  body .tutor-container {
    max-width: 100%;
  }
}
.loading-overlay {
  display: none;
  background: rgba(255, 255, 255, 0.7);
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  top: 0;
  z-index: 9998;
  align-items: center;
  justify-content: center;
}

.loading-overlay.is-active {
  display: flex;
}

.code {
  font-family: monospace;
  /*   font-size: .9em; */
  color: #dd4a68;
  background-color: rgb(238, 238, 238);
  padding: 0 3px;
}

.error {
  display: none;
}

.error .error-text {
  color: red;
  font-size: 17px;
  font-weight: 600;
}

.row .form-group label {
  font-size: 15px;
  font-weight: 700;
}

.tutor-dashboard
  .tutor-dashboard-content
  .tutor-capitalize-text
  .tutor-dashboard-title {
  text-transform: capitalize;
  border-bottom: 2px solid #2b7f58;
}
.wp-media-library-preview {
    padding: 30px;
    width: 387px;
}
.buttons {
    margin-bottom: 1%;
    margin-right: 36px;
}



</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<div class="warp">
    <div class="loading-overlay">
        <span class="fas fa-spinner fa-3x fa-spin"></span>
    </div>
    <div class="">
        <div class="row">
            <div class="">
                <form action="" class="annoucenement-form">
                    <div class="form-group mt-4">
                        <label for="title" class="text-bold">Resource Title</label>
                        <input type="text" class="form-control" id="title" placeholder="Enter Title">
                    </div>

                    <div class="form-group hidden mt-4">
                        <label for="howoften">Resource Type?</label>
                        <select class="form-control" id="resource_type">
                            <option value="">Select a type</option>
                            <option value="video">Video</option>
                            <option value="pdf">PDF</option>
                            <option value="useful-link">Useful Link</option>
                        </select>
                    </div>

                    <div class="form-group mt-4">
                        <label for="title" class="text-bold">Resource URL</label>
                        <input type="url" class="form-control" id="resouce_url" placeholder="">
                    </div>
                    <div class="form-group mt-4">
                        <label for="title" class="text-bold ms-3">Upload Thumbnail</label>
                        <input type="button" class="button wp-media-library-upload ms-2" value="Select Image">
                        <input type="hidden" class="wp-media-library-image-id" id="resource_image_id" name="resource_image_id" value="">
                        <div class="wp-media-library-preview"></div>
                    </div>

                    <div class="error">
                        <p class="error-text">

                        </p>
                    </div>
                    <button type="button" class="btn btn-success add-new-resource-ajax mt-4 w-100">Publish</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src='https://code.jquery.com/jquery-3.7.1.min.js' integrity='sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=' crossorigin='anonymous'></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

