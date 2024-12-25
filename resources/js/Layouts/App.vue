<template>
    <div>
        <NavBar> </NavBar>
        <slot name="content"> </slot>
    </div>
</template>

<script>
import NavBar from '@/Components/Main/NavBar.vue'

export default {
    components: {
        NavBar
    }
}
</script>

<style lang="css" scoped></style>
