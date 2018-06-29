<template>
    <div>
        <div class="row">
            <div class="col-md-8">
                <input 
                type="text" 
                class="form-control" 
                placeholder="CTRURL" 
                v-model="creative.ctrurl">
                <input 
                type="text" 
                class="form-control" 
                placeholder="Tags">
            </div>
            <div class="col-md-4">
                <button 
                class="btn btn-default" 
                @click="loadImage()">Refresh</button>
            </div>
        </div>
        <div id="ad_space" style="width: 300px; height: 250px; border: 1px solid black;">
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.getIds();
            this.ad_space = document.getElementById('ad_space');
        },

        data() {
            return {
                //ESSENTIALS
                token: this.token,
                creative_id: '',
                account_id: '',
                creative: {},
                ad_space: ''
            }
        },

        methods: {
            getIds() {
                var pathname = window.location.pathname;
                var ids = pathname.split("/");
                this.creative_id = ids[4];
                this.account_id = ids[2];
            },

            getCreative() {
                axios.get(
                    this.$root.api + '/creatives/' + this.creative_id,
                    this.$root.config
                ).then(response => {
                        this.creative = response.data.data;
                    }, error => {
                        alert(error);
                    }
                );
            },
            loadImage() {
                if(this.creative.class=="html5") this.loadHTMLImage();
                if(this.creative.class=="banner") this.loadBannerImage();
            },

            loadHTMLImage() {
                //Create and upload ad_iframe
                var ad_iframe = document.createElement('iframe');
                this.ad_space.appendChild(ad_iframe);
                var ad_iframe_content = ad_iframe.contentWindow.document;

                //Write the properties
                ad_iframe.width = 300;
                ad_iframe.height = 250;
                ad_iframe.frameBorder = 0;
                ad_iframe.scrolling = 'no';
                ad_iframe.style.overflow = 'hidden';
                ad_iframe.style.border = '0';
                ad_iframe.marginWidth = '0';
                ad_iframe.marginHeight = '0';
                ad_iframe.sandbox = "allow-forms allow-pointer-lock allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts allow-top-navigation-by-user-activation";
                
                //load response inside the ad_iframe
                var basic_script = "<script type='text/javascript' src='https://cdn.tapklik.com/js/tapklik.basic.js'><\/script>";
                
                var iframe_script = document.createElement('iframe');
                iframe_script.id = 'tapklik-ad';
                iframe_script.src="about:blank";
                iframe_script.frameBorder = '0';
                iframe_script.scrolling = 'no';
                iframe_script = iframe_script.outerHTML;

                var execution_script = document.createElement('script');
                execution_script.type="text/javascript";
                execution_script.innerText = 
                    `   var banner_url = '` + this.creative.html + `';
                        var width = ` + this.creative.w + `;
                        var height = ` + this.creative.h + `;
                        var ct = ` + this.creative.ctrurl + `; 
                        var gc = 'something.com';
                        var c = 'test'; 
                        var cr = 'test';
                        var b = 'test';
                        var ts = '15000000';
                        var loader_obj = {};
                        loader_obj['width'] = width;
                        loader_obj['height'] = height;
                        loader_obj['1pclick_url'] = gc || '';
                        loader_obj['click_urls'] = {};
                        loader_obj['click_urls']['clickTag'] = ct;
                        TK.html5.basicLoader('tapklik-ad', banner_url, loader_obj);`
                execution_script = execution_script.outerHTML;
                var content = basic_script + iframe_script + execution_script;
                console.log(content);
                ad_iframe_content.open();
                ad_iframe_content.write(content);
                ad_iframe_content.close();
            },
            
            loadBannerImage() {

            }
        },

        computed: {
        },

        watch: {
            token(value) {
                this.getCreative();
            },
            creative(value) {
                this.loadImage();
            }

        }
    }
</script>
