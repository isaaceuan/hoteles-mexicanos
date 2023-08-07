
    (function () {
        var BootLoader = {
            loadMode: 'async',
            head: document.getElementsByTagName("head")[0],
            resources: <?=$recursos?>,
            container: document.getElementById("widget-377441"),
            loader: null,
            body: null,

            boot: function () {
                this.log("Booting widget...");
                this.loader = document.createElement('div');
                this.loader.style.width = "100%";
                this.loader.style.minHeight = '100px';
                this.loader.style.backgroundImage = "url('<?=$urlLoading?>')";
                this.loader.style.backgroundPosition = "center center";
                this.loader.style.backgroundRepeat = 'no-repeat';
                this.loader.style.backgroundSize = '50px';
                this.container.appendChild(this.loader);

                this.body = document.createElement('div');
                this.body.style.display = "none";
                this.container.appendChild(this.body);

                this.loadBody();
            },

            log: function (message, type) {
                var styles = ['font-weight: bold;', 'font-weight: normal;'];
                message = "%c" + this.container.id + " %c" + message;
                type = type || 'info';

                switch (type) {
                    case 'error':
                        console.error(message, styles[0], styles[1]);
                        break;

                    case 'warning':
                        console.warn(message, styles[0], styles[1]);
                        break;

                    case 'info':
                    default:
                        console.log(message, styles[0], styles[1]);
                }
            },

            loadBody: function () {
                var xhttp = new XMLHttpRequest(),
                    self = this;
                this.log("Loading body...");
                xhttp.open('GET', "<?=$url?>", true);
                xhttp.onreadystatechange = function () {
                    console.log(this.statusText);
                    if (this.readyState !== XMLHttpRequest.DONE) {
                        return;
                    } else if (this.status === 200) {
                        self.body.innerHTML = this.responseText;
                        self.log("Body loaded, loading resources...");
                        self.loadResources();
                    } else {
                        this.loader.innerHTML = this.statusText === "" ? "Error loading widget" : this.statusText;
                        this.loader.style.color = '#d83636';
                        self.log("Error loading body -> " + this.statusText, 'error');
                    }
                };
                xhttp.send(null);
            },

            loadResources: function (index) {
                var index = index || 0,
                    resource = this.resources[index],
                    node = null,
                    self = this;

                switch (resource.type) {
                    case 'css':
                        node = document.createElement('link')
                        node.href = resource.src;
                        node.type = "text/css";
                        node.rel = "stylesheet";
                        break;

                    case 'js':
                        node = document.createElement('script');
                        node.src = resource.src;
                        node.type = "text/javascript";
                        if (this.loadMode === 'async') {
                            node.async = true;
                        } else if (this.loadMode === 'defer') {
                            node.defer = true;
                        }
                        break;
                }

                if (node) {
                    node.onload = function () {
                        self.log("Resource loaded -> " + resource.src);
                        if (++index < self.resources.length) {
                            self.loadResources(index);
                        } else {
                            self.loader.remove();
                            self.body.style.display = "block";
                            self.log("All resources loaded. Widget displayed.");
                        }
                    };

                    this.log("Loading resource -> " + resource.src);
                    this.head.appendChild(node);
                }
            }
        };

        BootLoader.boot();
    })();

