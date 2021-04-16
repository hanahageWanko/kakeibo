<template>
  <div
    class="button"
    :style="{ 'background-color': buttonColor, color: buttonTextColor }"
    :class="buttonSize"
  >
    <slot />
  </div>
</template>

<script lang="ts">
import { defineComponent, computed } from "vue";

interface Props {
  color: string;
  size: string;
}

export default defineComponent({
  name: "Button",
  components: {},
  props: {
    color: { type: String, default: "#00a167" },
    textcolor: { type: String, default: "" },
    size: { type: String, default: "" },
  },
  setup(props, { emit }) {
    const buttonColor = computed(() => `${props.color}`);
    const buttonTextColor = computed(() => `${props.textcolor}`);
    const buttonSize = computed(() => `${props.size}`);
    const onClick = () => {
      emit("click");
    };
    return {
      buttonColor,
      buttonTextColor,
      buttonSize,
      onClick,
    };
  },
});
</script>

<style scoped lang="scss">
@keyframes anim-ripple {
  0% {
    transform: scale(0);
    opacity: 1;
  }
  30% {
    transform: scale(1.5);
    opacity: 1;
  }
  100% {
    background-color: rgba(255, 255, 255, 0);
    opacity: 0;
  }
}
$large: 10px 20px;
$medium: 5px 14px;
$small: 4px 10px;
$radius-size: 2px;
$white: #ffffff;
$green: #00a167;
$darkmode-green: #00a167;
$gray: #a1a1a1;
$error: #f83b52;
$warning: #ffce44;
.button {
  text-align: center;
  padding: $medium;
  border-radius: $radius-size;
  border: 1px solid transparent;
  cursor: pointer;
  display: inline-block;
  position: relative;
  z-index: 1;
  overflow: hidden;
  color: $white;
  &.large {
    padding: $large;
  }
  &.small {
    padding: $small;
    font-size: 85%;
  }
  &::before {
    content: "";
    overflow: hidden;
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    border-radius: $radius-size;
    width: 100%;
    height: 100%;
    opacity: 0;
    background-color: $white;
    transition: ease 0.3s;
  }
  &::after {
    content: "";
    display: block;
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(255, 255, 255, 0.2);
    transform: scale(0);
    border-radius: 50%;
    z-index: -1;
    opacity: 0;
  }
  &:not(:active):after {
    animation: anim-ripple 1s ease forwards;
  }
  &:hover {
    &::before {
      opacity: 0.2;
    }
  }
  &.green {
    background-color: $green;
  }
}
.dark {
  &.button {
    background-color: $darkmode-green;
  }
}
</style>
