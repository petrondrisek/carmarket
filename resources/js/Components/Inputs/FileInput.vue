<script setup>
import { computed, toRefs } from 'vue';

const props = defineProps({
    progress: {type: Object, default: null},
    modelValue: {type: File, default: ''},
});

const emit = defineEmits([
    'update:modelValue'
]);

const { progress } = toRefs(props);

const value = computed({
  get: () => props.modelValue,
  set: (val) => {
    emit('update:modelValue', val)
  }
})

const changeFile = (e) => {
    let file = e.target.files[0];

    if(file) {
        value.value = e.target.files[0];
    }
}
</script>

<template>
    <input v-bind="$attrs" type="file" @change="changeFile" />
    <progress v-if="progress" :value="progress.percentage" max="100">
      {{ progress.percentage }}%
    </progress>
</template>

<script>
export default { inheritAttrs: false };
</script>