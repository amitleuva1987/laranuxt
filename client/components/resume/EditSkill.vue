<template>
  <form class="w-full">
    <div class="flex items-center border-b border-teal-500 py-2">
      <input v-model="local_skill.name" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" type="text" placeholder="Skill">
      <button class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:text-md border-4 text-white py-2 px-3 rounded" type="button" @click.once="edit_skill">
        SAVE
      </button>
      <button class="border-white bg-white border-4 text-teal-500 hover:text-teal-800 text-md py-2 px-2 rounded" type="button">
        Cancel
      </button>
    </div>
  </form>
</template>

<script lang="ts">
import Vue from 'vue'
import { Skill } from '@/types/api'
export default Vue.extend({
  name: 'EditSkill',
  props: {
    skill: {
      required: true,
      type: Object as () => Skill,
    },
  },
  data () {
    const local_skill = {} as Skill
    return {
      local_skill,
    }
  },
  mounted () {
    this.local_skill = this.skill
    console.log(this.local_skill)
  },
  methods: {
    async edit_skill ():Promise<void> {
      const data = {
        name: this.local_skill.name,
      }
      const url = 'skills/' + this.local_skill.id
      await this.$axios.put(url, data).then(() => {
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Skill Updated Successfully',
        })
        this.$emit('refresh_skills')
      }).catch(() => {
        this.$toast.show({
          type: 'danger',
          title: 'Error',
          message: 'Oops, something went wrong',
        })
      })
    },
  },
})
</script>
