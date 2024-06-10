import $ from "jquery";

class ImportVideos {
  constructor() {
    this.importVideosButton = $(".import-videos-button");

    this.events();
  }

  events() {
    this.importVideosButton.on("click", this.runImportVideos.bind(this));
  }

  runImportVideos(){
    this.importVideosButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Importing....');

    var data = $('#ytp-general-settings-form').serialize();

    $.ajax({
        url: ytp_local_data.root_url + "/wp-json/ytp/v1/import-videos",
        method: "POST",
        beforeSend: xhr => {
          xhr.setRequestHeader("X-WP-Nonce", ytp_local_data.nonce);
        },
        data: data,
        success: function (response) {

        },
        error: function (response) {

        }
      });
  }
}

export default ImportVideos;