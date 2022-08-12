<template>
  <form v-if="!show_add_skills_form" class="w-full" @submit.prevent="add_skill">
    <div class="flex items-center border-b border-teal-500 py-2">
      <Textinput
        id="name"
        :model-value.sync="skill.name"
        type="text"
        label="Name"
        required="required"
        placeholder="Skill Name"
        class="appearance-none block w-full text-gray-700 border border-blue-500 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
      />
      <button
        class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:text-md border-4 text-white py-2 px-3 rounded"
        type="submit"
      >
        SAVE
      </button>
      <button
        class="border-white bg-white border-4 text-teal-500 hover:text-teal-800 text-md py-2 px-2 rounded"
        type="button"
        @click="$emit('refresh_skills')"
      >
        Cancel
      </button>
    </div>
  </form>
</template>

<script lang="ts">
import Vue from 'vue'
import { Skill } from '@/types/api'
export default Vue.extend({
  name: 'AddSkill',
  data () {
    const skill = {} as Skill
    const show_add_skills_form:boolean = false
    return {
      skill,
      show_add_skills_form,
    }
  },
  methods: {
    async add_skill ():Promise<void> {
      const data = {
        name: this.skill.name,
      }
      await this.$axios.post('skills', data).then(() => {
        this.show_add_skills_form = !this.show_add_skills_form
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Skill Added Successfully',
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
