<script setup lang="ts">
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'

const model = defineModel<string>({ default: '' })

const editor = useEditor({
  content: model.value,
  extensions: [
    StarterKit.configure({
      heading: {
        levels: [1, 2, 3],
      },
    }),
  ],
  editorProps: {
    attributes: {
      class:
        'ProseMirror prose prose-sm dark:prose-invert max-w-none focus:outline-none',
    },
  },
  onUpdate: ({ editor }) => {
    model.value = editor?.getHTML()
  },
})

const btnClass = (isActive?: boolean) => {
  return {
    'bg-primary-500 dark:bg-dark_primary-500 text-white py-2 px-4': isActive,
    'py-2 px-4 hover:bg-gray-200 dark:hover:bg-gray-600 transition ease-in-out duration-150': !isActive,
  }
}
</script>

<template>
  <div class="bg-white dark:bg-gray-900">
    <!-- Toolbar -->
    <div
      class="flex flex-wrap gap-1 border-b bg-gray-100 p-2 dark:bg-gray-700 dark:border-gray-600"
    >
      <!-- Bold -->
      <button
        @click="editor?.chain().focus().toggleBold().run()"
        :class="btnClass(editor?.isActive('bold'))"
      >
        <strong>B</strong>
      </button>

      <!-- Italic -->
      <button
        @click="editor?.chain().focus().toggleItalic().run()"
        :class="btnClass(editor?.isActive('italic'))"
      >
        <em>I</em>
      </button>

      <!-- H2 -->
      <button
        @click="editor?.chain().focus().toggleHeading({ level: 2 }).run()"
        :class="btnClass(editor?.isActive('heading', { level: 2 }))"
      >
        H2
      </button>

      <!-- Bullet list -->
      <button
        @click="editor?.chain().focus().toggleBulletList().run()"
        :class="btnClass(editor?.isActive('bulletList'))"
      >
        • List
      </button>

      <!-- Ordered list -->
      <button
        @click="editor?.chain().focus().toggleOrderedList().run()"
        :class="btnClass(editor?.isActive('orderedList'))"
      >
        1. List
      </button>
    </div>

    <!-- Editor -->
    <div class="p-3 max-h-96 overflow-y-auto">
      <editor-content :editor="editor" />
    </div>
  </div>
</template>


<style scoped>
.ProseMirror {
  outline: none;
}

.ProseMirror p {
  margin: 0.5em 0;
}
</style>