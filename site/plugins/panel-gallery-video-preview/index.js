panel.plugin("meyrinctt/panel-gallery-video-preview", {
  blocks: {
    gallery: {
      data() {
        return {
          back: this.onBack() ?? "var(--block-color-back)"
        };
      },
      computed: {
        captionMarks() {
          return this.field("caption", { marks: true }).marks;
        },
        crop() {
          return this.content.crop;
        },
        isEmpty() {
          return !this.content.images?.length;
        },
        ratio() {
          return this.content.ratio;
        }
      },
      methods: {
        isVideo(file) {
          const mime = String(file.mime ?? "").toLowerCase();
          const source = [file.extension, file.filename, file.url]
            .filter(Boolean)
            .join(" ")
            .toLowerCase();

          return file.type === "video" || mime.startsWith("video/") || /\.(mp4|webm|mov|ogg)(?:$|[?#\s])/.test(source);
        },
        onBack(value) {
          const key = `kirby.galleryBlock.${this.endpoints.field}.${this.id}`;

          if (value === undefined) {
            return sessionStorage.getItem(key);
          }

          this.back = value;
          sessionStorage.setItem(key, value);
        },
        onVideoMetadata(event) {
          const video = event.currentTarget;

          if (Number.isFinite(video.duration) && video.duration > 0.1) {
            video.currentTime = 0.1;
          }
        },
        videoRatio() {
          return String(this.ratio || "1/1").replace("/", " / ");
        },
        videoUrl(file) {
          return `${file.url}#t=0.1`;
        }
      },
      render(h) {
        const placeholders = [1, 2, 3].map(index =>
          h("li", {
            key: index,
            class: "k-block-type-gallery-placeholder"
          }, [
            h("k-image-frame", {
              class: "k-block-type-gallery-frame",
              attrs: { ratio: this.ratio }
            })
          ])
        );

        const media = (this.content.images ?? []).map(file => {
          if (this.isVideo(file)) {
            return h("li", { key: file.id }, [
              h("div", {
                class: ["k-block-type-gallery-frame", "k-block-type-gallery-video-frame"],
                style: { aspectRatio: this.videoRatio() }
              }, [
                h("video", {
                  attrs: {
                    "aria-label": file.alt || file.filename || "Video",
                    muted: true,
                    playsinline: true,
                    preload: "metadata",
                    src: this.videoUrl(file)
                  },
                  domProps: { muted: true },
                  on: { loadedmetadata: this.onVideoMetadata }
                }),
                h("span", {
                  class: "k-block-type-gallery-video-play",
                  attrs: { "aria-hidden": "true" }
                })
              ])
            ]);
          }

          return h("li", { key: file.id }, [
            h("k-image-frame", {
              class: "k-block-type-gallery-frame",
              attrs: {
                alt: file.alt,
                cover: this.crop,
                ratio: this.ratio,
                src: file.url,
                srcset: file.image?.srcset
              }
            })
          ]);
        });

        const children = this.isEmpty ? placeholders : [
          ...media,
          h("k-block-background-dropdown", {
            attrs: { value: this.back },
            on: { input: this.onBack }
          })
        ];

        const figure = [
          h("ul", {
            on: { dblclick: this.open }
          }, children)
        ];

        if (this.content.caption) {
          figure.push(h("k-block-figure-caption", {
            attrs: {
              disabled: this.disabled,
              marks: this.captionMarks,
              value: this.content.caption
            },
            on: {
              input: caption => this.$emit("update", { caption })
            }
          }));
        }

        return h("figure", {
          class: "k-block-type-gallery-figure",
          style: { "--block-back": this.back },
          attrs: { "data-empty": this.isEmpty }
        }, figure);
      }
    }
  }
});
