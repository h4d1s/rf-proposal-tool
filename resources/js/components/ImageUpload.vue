<template>
  <div class="drop-area" @click="onClick($event)">
    <div class="preview">
      <img class="img-fluid" :src="imageSrc" v-show="imageSrc" alt="" />
      <p class="description">
        <span v-if="!imageSrc">Drag image to upload</span>
        <a
          v-else
          href="#"
          @click.prevent.stop="onClickRemove($event)">Remove Image</a>
      </p>
    </div>
    <input
      type="file"
      :name="inputName"
      ref="fileInput"
      accept="image/*" />
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
import axios from "axios";

export default defineComponent({
  data() {
    return {
      imageSrc: "",
      inputName: "file"
    }
  },
  props: {
    src: {
      type: String
    },
    name: {
      type: String
    },
  },
  async mounted() {
    this.$el.addEventListener("dragenter", this.onDragenter);
    this.$el.addEventListener("dragleave", this.onDragleave);
    this.$el.addEventListener("dragover", this.onDragover);
    this.$el.addEventListener("drop", this.onDrop);
    this.$el.querySelector("input").addEventListener("change", this.onUpdateImageDisplay);
    window.addEventListener("focus", this.onFocusBack);

    if(this.src) {
      const url = new URL(this.src);
      try {
        const { data } = await axios.get(url.href, { responseType: 'blob' });        
        const objectURL = URL.createObjectURL(new File([data], ""));
        if(objectURL) {
          this.imageSrc = objectURL;
        }
      } catch(err) {
        console.error(err);
      }
    }

    if(this.name) {
      this.inputName = this.name;
    }
  },
  methods: {
    onClick() {
      this.$el.classList.add("highlight");
      const inputFile = (this.$refs.fileInput as HTMLInputElement);
      inputFile.click();
    },
    onDragenter(e: DragEvent) {
      e.preventDefault();
      e.stopPropagation();

      this.$el.classList.add("highlight");
    },
    onDragleave(e: DragEvent) {
      e.preventDefault();
      e.stopPropagation();

      this.$el.classList.remove("highlight");
    },
    onDragover(e: DragEvent) {
      e.preventDefault();
      e.stopPropagation();

      this.$el.classList.add("highlight");
    },
    onDrop(e: DragEvent) {
      e.preventDefault();
      e.stopPropagation();

      this.$el.classList.remove("highlight");
      const dropppedFiles = e.dataTransfer?.files;
      if(dropppedFiles && dropppedFiles.length) {
        const file = dropppedFiles.item(0);
        if(file) {
          this.imageSrc = URL.createObjectURL(file);
          const dataTransfer = new DataTransfer();
          dataTransfer.items.add(file);
          (this.$refs.fileInput as HTMLInputElement).files = dataTransfer.files;
        }
      }
    },
    onFocusBack() {
      this.$el.classList.remove("highlight");
    },
    onClickRemove() {
      const inputFile = (this.$refs.fileInput as HTMLInputElement);
      this.imageSrc = "";
      inputFile.value = "";
    },
    onUpdateImageDisplay() {
      const inputFile = (this.$refs.fileInput as HTMLInputElement);
      const files = inputFile.files;
      if(files && files.length) {
        const file = files.item(0);
        if(file) {
          this.imageSrc = URL.createObjectURL(file);
        }
      }
    }
  }
});
</script>

<style lang="scss" scoped>
  .drop-area {
    display: flex;
    justify-content: center;
    text-align: center;
    align-items: center;
    background-color: #f3f5f6;
    border: 1px solid #ddd;
    border-radius: 6px;
    min-height: 150px;
    min-width: 150px;
    padding: 16px;
    transition: .3s all;

    input[type="file"] {
      display: none;
    }

    a {
      display: inline-block;
      margin-top: 12px;
    }
  }
  .description {
    margin: 0;
  }
  .highlight {
    background-color: #fff;
  }
</style>
