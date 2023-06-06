<script>
export default {
  methods: {
    handleFileUpload(event) {
      const file = event.target.files[0];
      this.$emit('update:modelValue', file);
    }
  }
};
</script>

<template>
    <input type="file" @change="handleFileUpload">
</template>