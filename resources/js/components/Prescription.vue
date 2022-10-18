<template>
    <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-container">
    
              <div class="modal-header">
                <slot name="header">
                    {{name}}
                </slot>
              </div>
    
              <div class="modal-body">
                <slot name="body">
                    <div class="container-iframe">
                        <!-- <iframe class="responsive-iframe"  src="https://docs.google.com/viewerng/viewer?url=http://192.168.70.98:8081/api/pdf/HomeInstructionPdf.pdf" width="1000" height="1000"></iframe> -->
                        <!-- <iframe class="responsive-iframe"  src="https://docs.google.com/gview?embedded=true&url=https://www.africau.edu/images/default/sample.pdf" width="1000" height="1000"></iframe> -->
                        <!-- <iframe class="responsive-iframe"  src="https://docs.google.com/viewerng/viewer?url=api/pdf/HomeInstructionPdf.pdf" width="1000" height="1000"></iframe> -->
                        <!-- <iframe class="responsive-iframe"  src="https://docs.google.com/viewerng/viewer?url=http://192.168.70.98:8081/api/pdf/" width="1000" height="1000"></iframe> -->
                       <!--  <iframe class="responsive-iframe"  src="https://docs.google.com/gview?embedded=true&url=http://192.168.70.98:8081/api/pdf/" width="1000" height="1000"></iframe> -->
                        <!-- <object data="http://192.168.70.98:8081/api/pdf/" type="application/pdf" frameborder="0" width="100%" height="600px" style="padding: 20px;">
                            <embed src="http://192.168.70.98:8081/api/pdf/" width="100%" height="600px"/> 
                        </object> -->
                        <!-- <object data='http://192.168.70.98:8081/api/pdf/' 
                        type='application/pdf' 
                        width='100%' 
                        height='700px'></object> -->  
                         <embed :src="'http://192.168.70.98:8081/api/pdf' + previewPdf" width="100%" height="600" type='application/pdf'>
                    </div>
                </slot>
              </div>
              <div class="modal-footer">
                <slot name="footer">
                  default footer
                  <button class="modal-default-button" @click="$emit('close')">
                    OK
                  </button>
                </slot>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </template>
    <script>
      export default {
        props: ['name']
      }
    </script>
    <style scoped>
        .container-iframe {
        position: relative;
        overflow: hidden;
        width: 100%;
        padding-top: 56.25%; /* 16:9 Aspect Ratio (divide 9 by 16 = 0.5625) */
        }

        /* Then style the iframe to fit in the container div with full height and width */
        .responsive-iframe {
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        right: 0;
        width: 100%;
        height: 100%;
        }

        * {
            box-sizing: border-box;
        }
        .modal-mask {
            position: fixed;
            z-index: 9998;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, .5);
            transition: opacity .3s ease;
            overflow-x: auto;
        }
        .modal-container {
            width: 75%;
            height: 100%;
            margin: 149px auto;
            padding: 20px 30px;
            background-color: #fff;
            border-radius: 2px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
            transition: all .3s ease;
        }
        .modal-body {
            margin: 20px 0;
        }
        /*
         * The following styles are auto-applied to elements with
         * transition="modal" when their visibility is toggled
         * by Vue.js.
         *
         * You can easily play with the modal transition by editing
         * these styles.
         */
        .modal-enter {
          opacity: 0;
        }
        .modal-leave-active {
          opacity: 0;
        }
        .modal-enter .modal-container,
        .modal-leave-active .modal-container {
          -webkit-transform: scale(1.1);
          transform: scale(1.1);
        }
        </style>