<template>
  <section>
    <h2 class="text-xl mb-3 border-b-2 border-yellow-900 pb-3">Skills</h2>
    <ul class="mt-5 mb-3 border-b-2 border-yellow-900 pb-3">
      <li
        v-for="c_skill in skills"
        :key="c_skill.id"
        class="bg-white px-3 py-2 flex justify-between mb-2"
      >
        <span>
          {{ c_skill.name }}
        </span>
        <span>
          <button
            type="button"
            class="text-blue-700"
            @click.once="edit(c_skill)"
          >Edit
          </button>
          |
          <button
            type="button"
            class="text-red-500"
            @click.once="danger(c_skill.id)"
          >
            Delete
          </button>
        </span>
      </li>

      <div v-if="!enable_add" class="w-full flex justify-center mt-5">
        <button
          class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-md border-4 text-white py-2 px-3 rounded"
          type="button"
          @click="enable_add = !enable_add"
        >
          ADD NEW SKILL
        </button>
      </div>
      <add-skill v-if="enable_add" @refresh_skills="refresh_skills" />
      <edit-skill v-if="enable_edit" :skill="skill" @refresh_skills="refresh_edit" />
    </ul>
  </section>
</template>

<script lang="ts">
import Vue from 'vue'
import AddSkill from './AddSkill.vue'
import EditSkill from './EditSkill.vue'
import { Skill } from '@/types/api'

export default Vue.extend({
  name: 'ListSkills',
  components: { AddSkill, EditSkill },

  data () {
    const skills:Skill[] = []
    const skill = {} as Skill
    const deleted:boolean = false
    const enable_add:boolean = false
    const enable_edit:boolean = false
    const edit_skill_id:number = 0

    return {
      skills,
      skill,
      deleted,
      edit_skill_id,
      enable_add,
      enable_edit,
    }
  },
  mounted () {
    this.get_skills()
    this.deleted = true
  },
  methods: {
    edit (skill:Skill) {
      this.enable_edit = !this.enable_edit
      this.skill = skill
    },

    async get_skills ():Promise<void> {
      this.skills = (await this.$axios.get('skills')).data.data as Skill[]
    },

    danger (id:number) {
      this.$modal.show({
        type: 'danger',
        title: 'Are you sure?',
        body: 'once removed, you will not be able to get it back.',
        secondary: {
          label: 'Cancel',
          theme: 'while',
          action: () => this.$toast.success('You cancelled deletion'),
        },
        primary: {
          label: 'Confirm Delete',
          theme: 'red',
          action: () => this.delete_skill(id),
        },
      })
    },

    async delete_skill (id:number):Promise<void> {
      const url = 'skills/' + id
      await this.$axios.delete(url).then(() => {
        this.refresh_skills()
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Skill Deleted Successfully',
        })
        this.refresh_skills()
      }).catch(() => {
        this.$toast.show({
          type: 'danger',
          title: 'Error',
          message: 'Oops, something went wrong',
        })
      })
    },

    async refresh_skills ():Promise<void> {
      this.skills = (await this.$axios.get('skills')).data.data as Skill[]
    },
    async refresh_edit ():Promise<void> {
      this.skills = (await this.$axios.get('skills')).data.data as Skill[]
      this.enable_edit = !this.enable_edit
    },
  },
})

</script>
