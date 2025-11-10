@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-900" x-data="pesanApp()">
        <!-- Main Chat Container -->
        <div class="flex h-screen bg-gray-900">
            <!-- Sidebar Conversations -->
            <div class="w-1/3 bg-gray-800 border-r border-gray-700 flex flex-col">
                <!-- User Profile Header -->
                <div class="p-4 bg-gray-800 border-b border-gray-700 flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <!-- User Avatar -->
                        <div class="relative">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-purple-500 to-blue-600 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                <span x-text="initials('{{ auth()->user()->name }}')"></span>
                            </div>
                            <div
                                class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-gray-800">
                            </div>
                        </div>
                        <div>
                            <h2 class="text-white font-semibold">{{ auth()->user()->name }}</h2>
                            <p class="text-gray-400 text-sm">Online</p>
                        </div>
                    </div>
                    <div class="flex space-x-4">
                        <button class="text-gray-400 hover:text-white transition-colors">
                            <i class="fas fa-comment-alt text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Search Bar -->
                <div class="p-3 bg-gray-800 border-b border-gray-700">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" placeholder="Cari atau mulai percakapan baru"
                            class="w-full pl-10 pr-4 py-2 bg-gray-700 text-white rounded-lg border-none focus:outline-none focus:ring-2 focus:ring-blue-500 placeholder-gray-400">
                    </div>
                </div>

                <!-- Conversations List -->
                <div class="flex-1 overflow-y-auto bg-gray-800">
                    <template x-if="conversations.length === 0">
                        <div class="flex flex-col items-center justify-center h-full p-8 text-center">
                            <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-comments text-gray-400 text-xl"></i>
                            </div>
                            <p class="text-gray-400 font-medium">Belum ada percakapan</p>
                            <p class="text-sm text-gray-500 mt-1">Mulai percakapan baru dengan seseorang</p>
                        </div>
                    </template>

                    <template x-for="conv in conversations" :key="conv.id">
                        <div @click="openConversation(conv)"
                            class="p-3 hover:bg-gray-700 cursor-pointer border-b border-gray-700 transition-colors"
                            :class="{ 'bg-gray-700': conv.id === currentConversation?.id }">
                            <div class="flex items-center space-x-3">
                                <!-- Contact Avatar -->
                                <div class="relative">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                        <template x-if="conv.other.avatar">
                                            <img :src="conv.other.avatar" class="w-full h-full rounded-full object-cover"
                                                alt="" />
                                        </template>
                                        <template x-if="!conv.other.avatar">
                                            <span x-text="initials(conv.other.name)"></span>
                                        </template>
                                    </div>
                                    <div
                                        class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 rounded-full border-2 border-gray-800">
                                    </div>
                                </div>

                                <!-- Conversation Info -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-center mb-1">
                                        <h3 class="text-white font-medium truncate" x-text="conv.other.name"></h3>
                                        <span class="text-xs text-gray-400"
                                            x-text="formatTime(conv.last_message_time)"></span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <p class="text-sm text-gray-400 truncate"
                                            x-text="conv.last_message_preview ?? 'Tidak ada pesan'"></p>
                                        <div class="flex items-center space-x-1">
                                            <template x-if="conv.unread_count > 0">
                                                <span
                                                    class="bg-green-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"
                                                    x-text="conv.unread_count"></span>
                                            </template>
                                            <i class="fas fa-check-double text-gray-500 text-xs"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <!-- Main Chat Area -->
            <div class="flex-1 flex flex-col bg-gray-900">
                <!-- Chat Header -->
                <div class="p-3 bg-gray-800 border-b border-gray-700 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <!-- Contact Avatar -->
                        <div class="relative">
                            <div
                                class="w-10 h-10 bg-gradient-to-br from-green-400 to-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                <template x-if="currentConversation?.other.avatar">
                                    <img :src="currentConversation.other.avatar"
                                        class="w-full h-full rounded-full object-cover" alt="" />
                                </template>
                                <template x-if="!currentConversation?.other.avatar">
                                    <span
                                        x-text="currentConversation ? initials(currentConversation.other.name) : ''"></span>
                                </template>
                            </div>
                            <div
                                class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-400 rounded-full border-2 border-gray-800">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Messages Area -->
                <div class="flex-1 overflow-y-auto bg-gray-900 bg-chat-pattern" x-ref="messagesBox"
                    style="background-image: url('data:image/svg+xml,%3Csvg width=\"100\" height=\"100\" viewBox=\"0 0 100 100\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z\" fill=\"%23333\" fill-opacity=\"0.05\" fill-rule=\"evenodd\"/%3E%3C/svg%3E');">

                    <template x-if="!currentConversation">
                        <div class="flex flex-col items-center justify-center h-full text-center p-8">
                            <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-comments text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-300 mb-2">Pilih Percakapan</h3>
                            <p class="text-gray-400 max-w-md">Pilih percakapan dari daftar di sebelah kiri untuk mulai
                                mengobrol</p>
                        </div>
                    </template>

                    <template x-if="currentConversation && messages.length === 0">
                        <div class="flex flex-col items-center justify-center h-full text-center p-8">
                            <div class="w-24 h-24 bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-envelope-open-text text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-300 mb-2">Belum ada pesan</h3>
                            <p class="text-gray-400">Mulai percakapan dengan mengirim pesan pertama</p>
                        </div>
                    </template>

                    <!-- Messages -->
                    <template x-for="msg in messages" :key="msg.id">
                        <div class="px-4 py-1">
                            <div class="flex"
                                :class="msg.sender.id === {{ auth()->id() }} ? 'justify-end' : 'justify-start'">
                                <div class="max-w-[70%]">
                                    <div class="rounded-lg px-4 py-2 shadow-sm"
                                        :class="msg.sender.id === {{ auth()->id() }} ?
                                            'bg-green-700 text-white rounded-br-none' :
                                            'bg-gray-800 text-gray-100 rounded-bl-none'">

                                        <!-- Message text -->
                                        <div x-text="msg.body" class="whitespace-pre-wrap break-words text-sm"></div>

                                        <!-- Attachment -->
                                        <template x-if="msg.attachment">
                                            <div class="mt-2">
                                                <img :src="msg.attachment"
                                                    class="max-w-full max-h-64 rounded-lg cursor-pointer hover:opacity-90 transition-opacity"
                                                    @click="openImage(msg.attachment)" />
                                            </div>
                                        </template>

                                        <!-- Timestamp -->
                                        <div class="text-xs mt-1 text-right opacity-70"
                                            :class="msg.sender.id === {{ auth()->id() }} ? 'text-green-200' : 'text-gray-400'"
                                            x-text="formatMessageTime(msg.created_at)">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Typing Indicator -->
                    <div x-show="isTyping" class="px-4 py-1">
                        <div class="flex justify-start">
                            <div class="max-w-[70%]">
                                <div class="bg-gray-800 text-gray-100 rounded-lg rounded-bl-none px-4 py-2 shadow-sm">
                                    <div class="flex items-center space-x-1">
                                        <div class="flex space-x-1">
                                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                                                style="animation-delay: 0.1s"></div>
                                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                                                style="animation-delay: 0.2s"></div>
                                        </div>
                                        <span class="text-xs text-gray-400 ml-2">mengetik...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Message Input Area -->
                <div class="p-3 bg-gray-800 border-t border-gray-700" x-show="currentConversation">
                    <form @submit.prevent="sendMessage" class="flex items-center space-x-2">
                        <input type="file" x-ref="file" @change="onFileChange" class="hidden" accept="image/*" />

                        <button type="button" class="text-gray-400 hover:text-white p-2 transition-colors"
                            @click="$refs.file.click()">
                            <i class="fas fa-paperclip text-xl"></i>
                        </button>

                        <div class="flex-1">
                            <textarea x-model="newMessage" placeholder="Ketik pesan" rows="1"
                                class="w-full px-4 py-3 bg-gray-700 text-white rounded-full border-none focus:outline-none focus:ring-2 focus:ring-green-500 placeholder-gray-400 resize-none transition-all duration-200"
                                @input="autoResize"></textarea>
                        </div>

                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white p-3 rounded-full transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            :disabled="!newMessage.trim() && !fileToSend">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Force dark mode and prevent light mode */
        body {
            background-color: #111827 !important;
            color: #f9fafb !important;
        }

        /* Custom scrollbar for dark theme */
        .overflow-y-auto::-webkit-scrollbar {
            width: 6px;
        }

        .overflow-y-auto::-webkit-scrollbar-track {
            background: #374151;
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb {
            background: #6b7280;
            border-radius: 3px;
        }

        .overflow-y-auto::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Chat background pattern */
        .bg-chat-pattern {
            background-color: #111827;
            background-blend-mode: overlay;
        }

        /* Message animations */
        @keyframes messageSlideIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .px-4.py-1>div {
            animation: messageSlideIn 0.3s ease-out;
        }

        /* Ensure all text is visible in dark mode */
        .text-gray-900 {
            color: #f9fafb !important;
        }

        .text-gray-800 {
            color: #f3f4f6 !important;
        }

        .text-gray-700 {
            color: #e5e7eb !important;
        }

        .text-gray-600 {
            color: #d1d5db !important;
        }

        /* Override any light backgrounds */
        .bg-white {
            background-color: #1f2937 !important;
        }

        .bg-gray-50 {
            background-color: #111827 !important;
        }

        .bg-gray-100 {
            background-color: #1f2937 !important;
        }
    </style>

    <script>
        function pesanApp() {
            return {
                conversations: @json($conversationsForJs ?? []),
                currentConversation: null,
                messages: [],
                newMessage: '',
                fileToSend: null,
                isTyping: false,

                initials(name) {
                    if (!name) return '';
                    const parts = name.trim().split(' ');
                    if (parts.length === 1) return parts[0].slice(0, 2).toUpperCase();
                    return (parts[0][0] + (parts[1] ? parts[1][0] : '')).toUpperCase();
                },

                openConversation(conv) {
                    this.currentConversation = conv;
                    this.messages = [];
                    fetch(`/pesan/conversations/${conv.id}/messages?limit=200`, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(r => r.json())
                        .then(data => {
                            this.messages = Array.isArray(data) ? data : (data.data || []);
                            this.$nextTick(() => this.scrollToBottom());

                            if (window.Echo) {
                                try {
                                    window.Echo.leavePrivate(`conversation.${conv.id}`);
                                } catch (e) {}
                                window.Echo.private(`conversation.${conv.id}`)
                                    .listen('MessageSent', (e) => {
                                        const incoming = {
                                            id: e.id,
                                            conversation_id: e.conversation_id,
                                            sender: e.sender,
                                            body: e.body,
                                            attachment: e.attachment,
                                            created_at: e.created_at
                                        };
                                        this.messages.push(incoming);
                                        this.$nextTick(() => this.scrollToBottom());
                                    });
                            }
                        })
                        .catch(err => console.error('Gagal load messages', err));
                },

                onFileChange(e) {
                    const f = e.target.files[0];
                    if (!f) return;
                    this.fileToSend = f;
                },

                sendMessage() {
                    if (!this.currentConversation) return;
                    const form = new FormData();
                    form.append('body', this.newMessage || '');
                    if (this.fileToSend) form.append('attachment', this.fileToSend);

                    fetch(`/pesan/conversations/${this.currentConversation.id}/messages`, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content')
                            },
                            body: form
                        })
                        .then(r => r.json())
                        .then(res => {
                            const msg = res.message ?? res.data ?? res;
                            if (msg) {
                                this.messages.push(msg);
                                this.newMessage = '';
                                this.fileToSend = null;
                                this.$refs.file.value = null;
                                this.$nextTick(() => this.scrollToBottom());
                            }
                        })
                        .catch(e => console.error('Gagal kirim pesan', e));
                },

                scrollToBottom() {
                    const el = this.$refs.messagesBox;
                    if (el) el.scrollTop = el.scrollHeight;
                },

                formatTime(dt) {
                    try {
                        const d = new Date(dt);
                        const now = new Date();
                        const diff = now - d;
                        const minutes = Math.floor(diff / (1000 * 60));
                        const hours = Math.floor(diff / (1000 * 60 * 60));
                        const days = Math.floor(diff / (1000 * 60 * 60 * 24));

                        if (minutes < 1) return 'Baru saja';
                        if (minutes < 60) return `${minutes}m`;
                        if (hours < 24) return `${hours}j`;
                        if (days === 1) return 'Kemarin';
                        if (days < 7) return `${days}h`;
                        return d.toLocaleDateString('id-ID', {
                            day: 'numeric',
                            month: 'short'
                        });
                    } catch (e) {
                        return dt;
                    }
                },

                formatMessageTime(dt) {
                    try {
                        const d = new Date(dt);
                        return d.toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    } catch (e) {
                        return dt;
                    }
                },

                autoResize(e) {
                    e.target.style.height = 'auto';
                    e.target.style.height = e.target.scrollHeight + 'px';
                },

                openImage(url) {
                    window.open(url, '_blank');
                },

                initOpenFromQuery() {
                    const params = new URLSearchParams(window.location.search);
                    const convId = params.get('conv');
                    if (!convId) return;
                    const found = this.conversations.find(c => String(c.id) === String(convId));
                    if (found) this.openConversation(found);
                }
            }
        }

        // Force dark mode on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.documentElement.classList.add('dark');
            document.body.classList.add('dark');
        });

        document.addEventListener('alpine:init', () => {});
        setTimeout(() => {
            const el = document.querySelector('[x-data="pesanApp()"]');
            if (el && el.__x) {
                el.__x.$data.initOpenFromQuery();
            }
        }, 200);
    </script>
@endsection
