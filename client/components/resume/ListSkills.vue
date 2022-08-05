<template>
  <section>
    <h2 class="text-xl mb-3 border-b-2 border-yellow-900 pb-3">Skills</h2>
    <ul class="mt-5 mb-3 border-b-2 border-yellow-900 pb-3">
      <li v-for="skill in get_store_skills" :key="skill.id" class="bg-white px-3 py-2 flex justify-between mb-2">
        <span>{{ skill.name }}</span>
        <span><button type="button" class="text-blue-700" @click.once="edit(skill.id)">Edit</button> | <button type="button" class="text-red-500" @click.once="danger(skill.id)">Delete</button></span>
      </li>

      <div v-if="!$accessor.skill.addnewskill" class="w-full flex justify-center mt-5">
        <button class="bg-blue-500 hover:bg-blue-700 border-blue-500 hover:border-blue-700 text-md border-4 text-white py-2 px-3 rounded" type="button" @click="toggleAddNewSkill">
          ADD NEW SKILL
        </button>
      </div>
      <add-skill v-if="$accessor.skill.addnewskill" />
      <edit-skill v-if="$accessor.skill.editskill" :id="edit_skill_id" />
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
    const deleted:boolean = false
    const edit_skill_id:number = 0

    return {
      skills,
      deleted,
      edit_skill_id,
    }
  },
  computed: {
    get_store_skills ():Skill[] {
      return this.$accessor.skill.getSkills
    },
  },
  mounted () {
    this.get_skills()
    this.deleted = true
  },
  methods: {
    edit (id:number) {
      this.edit_skill_id = id
      this.toggleEditSkill()
    },
    toggleAddNewSkill ():void {
      this.$accessor.skill.setAddnewSkill()
    },

    toggleEditSkill ():void {
      this.$accessor.skill.setEditSkill()
    },

    async get_skills ():Promise<void> {
      this.skills = (await this.$axios.get('skills')).data.data as Skill[]
      this.$accessor.skill.setSkills(this.skills)
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
      await this.$axios.delete(url).then((response) => {
        this.refresh_skills()
        this.$toast.show({
          type: 'success',
          title: 'Success',
          message: 'Skill Deleted Successfully',
        })
        this.$accessor.skill.updateSkills()
      }).catch((error) => {
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
  },
})

</script>
