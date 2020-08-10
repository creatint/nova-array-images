<template>
  <panel-item :field="field">
    <div slot="value" class="flex flex-row overflow-x-auto py-2">
      <img
          v-for="img in images"
          :src="img.url"
          :alt="img.src"
          style="height: 8rem; width: auto;"
          class="rounded shadow-md mr-2"
      >
    </div>
  </panel-item>
</template>

<script>
export default {
  props: ['resource', 'resourceName', 'resourceId', 'field'],
  data(){
    return {
      images: []
    };
  },
  created() {
    const app = this;
    this.value = this.field.value || '';

    const fd = new FormData();
    fd.append('disk', this.field.disk);

    const srcs = JSON.parse(this.field.value) || [];

    if (!srcs) {
      app.images = [];
      return;
    }

    for (var i = 0; i < srcs.length; i++) {
      fd.append('srcs[]', srcs[i]);
    }
    axios.post('/nova-vendor/array-images/urls', fd)
        .then(res => {
          app.images.push(...res.data);
        });
  },
}
</script>
