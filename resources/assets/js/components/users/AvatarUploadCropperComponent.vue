<template>
    <div>
        <div class="image-upload-crop">
            <a href="javascript:"
               class="image-upload-crop__file"
               ref="fileWrap"
               :style="styleObject">
                <i class="fa fa-plus add-button"></i>
                <input type="file" v-on:change="handleChange" ref="inputFile">
            </a>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="croppedModal" tabindex="-1" role="dialog" aria-labelledby="croppedModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div style="width: 100%;min-height: 200px;">
                            <div class="image-upload-crop__crop-area">
                                <img ref="willCroppedImage" src="" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" v-on:click="handleSubmit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import Cropper from 'cropperjs';
  import 'cropperjs/dist/cropper.css';

  export default {
    props: [
      'defaultAvatar',
      'allowedMimeTypes',
      'aspectRatio',
      'croppedWidth',
      'croppedHeight'
    ],
    data() {
      return {
        //allowedMimeTypes: ['image/jpeg', 'image/png'],
        cropDetails: null,
        cropperInstance: null,
        styleObject: {
          backgroundImage: `url(${this.defaultAvatar})`
        }
      }
    },
    mounted() {
      let willCroppedImage = this.$refs.willCroppedImage;
      $('#croppedModal').on('shown.bs.modal', () => {
        this.cropperInstance = new Cropper(willCroppedImage, {
          aspectRatio: 1,
          //viewMode: 3,
          crop: (e) => {
            this.cropDetails = e.detail;
          }
        });
      }).on('hidden.bs.modal', () => {
        this.cropperInstance.destroy();
      });
    },
    destroyed() {
      this.cropperInstance.destroy();
    },
    methods: {
      showModal() {
        $('#croppedModal').modal('show');
      },
      closeModal() {
        $('#croppedModal').modal('hide');
      },
      checkFileTypes() {
        if (this.allowedMimeTypes.indexOf(this.$refs.inputFile.files[0].type) === -1) {
          // throw new Error('Not supported file types');
          alert('Not supported file types');
          return false;
        }
        return true;
      },
      handleChange(e) {
        if (!this.checkFileTypes()) {
          return;
        }
        let fileReader = new FileReader();
        fileReader.onload = (e) => {
          this.$refs.willCroppedImage.src = fileReader.result;
          this.showModal();
        };
        fileReader.readAsDataURL(this.$refs.inputFile.files[0]);
      },
      handleSubmit(e) {
        let that = this;
        e.preventDefault();
        if (!this.cropDetails) {
          alert('no file is selected!');
          return;
        }
        let canvas = this.cropperInstance.getCroppedCanvas({
          width: this.croppedWidth,
          height: this.croppedHight,
          maxWidth: 4096,
          maxHeight: 4096,
        });
        // upload to server with dataURL
        let dataURL = canvas.toDataURL();
        // or upload to server with formData
        canvas.toBlob(function (blob) {
          let formData = new FormData();
          formData.append('avatar', blob);
          axios.post('/api/user/avatar', formData).then((response) => {
            let fileWrap = that.$refs.fileWrap;
            fileWrap.style.backgroundImage = `url(${response.data.avatar_url})`;
            that.closeModal();
          }).catch(error => console.error(error));
        });
      }
    }
  };
</script>

<style scoped lang="scss">
    .image-upload-crop {
        display: flex;
        flex-direction: column;
        .image-upload-crop__file {
            border: 1px solid #f5f5f5;
            background-color: #fff;
            background-repeat: no-repeat;
            background-size: cover;
            overflow: hidden;
            text-decoration: none;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            height: 100px;
            cursor: pointer;
            &:focus, &:hover {
                cursor: pointer;
            }
            .add-button {
                font-size: 1.25rem;
                color: #ddd;
                //text-shadow: 1px 1px 1px #eee;
            }
            > input {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                opacity: 0;
            }
        }
    }

    .image-upload-crop__crop-area {
        width: 100%;
        img {
            max-width: 100%;
        }
    }
</style>