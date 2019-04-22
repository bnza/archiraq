<template >
    <vl-source-xyz :url="url" />
</template>

<script>
export default {
    name: 'VlSourceEsri',
    props: {
        imagerySet: {
            type: String,
            default: 'World_Imagery'
        }
    },
    computed: {
        url() {
            return `https://server.arcgisonline.com/ArcGIS/rest/services/${this.imagerySet}/MapServer/tile/{z}/{y}/{x}`;
        }
    }
};
</script>
