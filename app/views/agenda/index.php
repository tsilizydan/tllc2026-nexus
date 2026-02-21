<?php $pageTitle = __('agenda'); ?>
<div x-data="calendarApp()" x-init="loadEvents()">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-3">
        <h1 class="text-2xl font-bold text-white"><i class="fas fa-calendar-alt text-accent-400 mr-3"></i><?= __('agenda') ?></h1>
        <div class="flex items-center gap-2">
            <!-- View toggles -->
            <div class="flex rounded-lg overflow-hidden border border-white/10">
                <button @click="viewMode = 'month'" :class="viewMode === 'month' ? 'bg-primary-500/20 text-primary-300' : 'text-slate-500 hover:text-white'" class="px-3 py-1.5 text-xs font-medium transition-colors"><?= __('view_month') ?></button>
                <button @click="viewMode = 'week'" :class="viewMode === 'week' ? 'bg-primary-500/20 text-primary-300' : 'text-slate-500 hover:text-white'" class="px-3 py-1.5 text-xs font-medium transition-colors"><?= __('view_week') ?></button>
            </div>
            <button @click="showEventModal = true; editingEvent = null; resetForm()" class="btn-primary inline-flex items-center gap-2 text-sm"><i class="fas fa-plus"></i><?= __('new_event') ?></button>
        </div>
    </div>

    <div class="grid lg:grid-cols-4 gap-4">
        <!-- Calendar Main -->
        <div class="lg:col-span-3 card p-4 sm:p-6">
            <!-- Calendar Header -->
            <div class="flex items-center justify-between mb-4">
                <button @click="prevMonth()" class="btn-secondary text-sm px-3 py-1.5"><i class="fas fa-chevron-left"></i></button>
                <h2 class="text-lg font-semibold text-white" x-text="monthNames[currentMonth] + ' ' + currentYear"></h2>
                <div class="flex gap-2">
                    <button @click="goToday()" class="btn-secondary text-xs px-3 py-1.5">Aujourd'hui</button>
                    <button @click="nextMonth()" class="btn-secondary text-sm px-3 py-1.5"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>

            <!-- Days Header -->
            <div class="grid grid-cols-7 mb-2">
                <template x-for="day in dayLabels">
                    <div class="py-2 text-center text-xs font-medium text-slate-500" x-text="day"></div>
                </template>
            </div>

            <!-- Month View -->
            <template x-if="viewMode === 'month'">
                <div class="grid grid-cols-7 gap-1">
                    <template x-for="day in calendarDays" :key="day.key">
                        <div class="min-h-[70px] sm:min-h-[85px] p-1.5 rounded-lg transition-colors cursor-pointer"
                             :class="{
                                 'bg-white/5 hover:bg-white/8': day.isCurrentMonth,
                                 'opacity-40': !day.isCurrentMonth,
                                 'ring-1 ring-primary-500/50 bg-primary-500/5': day.isToday
                             }"
                             @click="selectDate(day.date)">
                            <span class="text-xs font-medium" :class="day.isToday ? 'text-primary-400 font-bold' : 'text-slate-400'" x-text="day.number"></span>
                            <div class="mt-0.5 space-y-0.5">
                                <template x-for="event in day.events.slice(0, 3)">
                                    <div class="text-[10px] px-1.5 py-0.5 rounded truncate cursor-pointer hover:opacity-80"
                                         :style="'background:' + (event.color || '#6C3CE1') + '25; color:' + (event.color || '#6C3CE1')"
                                         @click.stop="openEditEvent(event)" x-text="event.title"></div>
                                </template>
                                <div x-show="day.events.length > 3" class="text-[9px] text-slate-500 text-center" x-text="'+' + (day.events.length - 3)"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>

            <!-- Week View -->
            <template x-if="viewMode === 'week'">
                <div class="space-y-1">
                    <template x-for="day in weekDays" :key="day.key">
                        <div class="flex gap-3 p-3 rounded-lg transition-colors" :class="day.isToday ? 'bg-primary-500/5 ring-1 ring-primary-500/30' : 'bg-white/3 hover:bg-white/5'">
                            <div class="w-14 text-center flex-shrink-0">
                                <div class="text-xs text-slate-500" x-text="day.dayName"></div>
                                <div class="text-lg font-bold" :class="day.isToday ? 'text-primary-400' : 'text-white'" x-text="day.number"></div>
                            </div>
                            <div class="flex-1 space-y-1">
                                <template x-for="event in day.events">
                                    <div @click="openEditEvent(event)" class="flex items-center gap-2 px-3 py-2 rounded-lg cursor-pointer hover:opacity-80 text-sm"
                                         :style="'background:' + (event.color || '#6C3CE1') + '15; border-left: 3px solid ' + (event.color || '#6C3CE1')">
                                        <span :style="'color:' + (event.color || '#6C3CE1')" x-text="event.title" class="font-medium"></span>
                                        <span class="text-xs text-slate-500 ml-auto" x-text="event.start ? event.start.substring(11,16) : ''"></span>
                                    </div>
                                </template>
                                <div x-show="day.events.length === 0" class="text-xs text-slate-600 py-2">—</div>
                            </div>
                        </div>
                    </template>
                </div>
            </template>
        </div>

        <!-- Upcoming Events Sidebar -->
        <div class="card p-4">
            <h3 class="text-sm font-semibold text-white mb-3"><i class="fas fa-clock text-accent-400 mr-2"></i>À venir</h3>
            <div class="space-y-2">
                <template x-for="event in upcomingEvents" :key="event.id">
                    <div @click="openEditEvent(event)" class="p-3 rounded-lg bg-white/3 hover:bg-white/5 cursor-pointer transition-colors">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="w-2 h-2 rounded-full" :style="'background:' + (event.color || '#6C3CE1')"></div>
                            <span class="text-sm font-medium text-white truncate" x-text="event.title"></span>
                        </div>
                        <div class="text-xs text-slate-500" x-text="formatDate(event.start)"></div>
                        <div x-show="event.location" class="text-xs text-slate-600 mt-0.5"><i class="fas fa-map-marker-alt mr-1"></i><span x-text="event.location"></span></div>
                    </div>
                </template>
                <div x-show="upcomingEvents.length === 0" class="text-xs text-slate-500 text-center py-4"><?= __('no_results') ?></div>
            </div>
        </div>
    </div>

    <!-- Event Modal (Create + Edit) -->
    <div x-show="showEventModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-transition>
        <div class="absolute inset-0 bg-black/60" @click="showEventModal = false"></div>
        <div class="relative glass-solid rounded-2xl w-full max-w-md p-6" @click.stop>
            <h3 class="text-lg font-semibold text-white mb-4" x-text="editingEvent ? 'Modifier l\'événement' : '<?= __('new_event') ?>'"></h3>
            <form method="POST" :action="editingEvent ? '<?= url('/agenda/') ?>' + editingEvent.id + '/update' : '<?= url('/agenda/store') ?>'" class="space-y-4">
                <?= csrf_field() ?>
                <div><label class="block text-sm text-slate-300 mb-1"><?= __('event_title') ?> *</label><input type="text" name="title" class="input" required x-model="formTitle"></div>
                <div><label class="block text-sm text-slate-300 mb-1">Description</label><textarea name="description" rows="2" class="input" x-model="formDesc"></textarea></div>
                <div class="grid grid-cols-2 gap-3">
                    <div><label class="block text-sm text-slate-300 mb-1"><?= __('event_start') ?></label><input type="datetime-local" name="start_date" class="input" x-model="formStart" required></div>
                    <div><label class="block text-sm text-slate-300 mb-1"><?= __('event_end') ?></label><input type="datetime-local" name="end_date" class="input" x-model="formEnd"></div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div><label class="block text-sm text-slate-300 mb-1">Couleur</label><input type="color" name="color" x-model="formColor" class="w-full h-10 rounded-lg cursor-pointer bg-transparent border border-white/10"></div>
                    <div><label class="block text-sm text-slate-300 mb-1">Lieu</label><input type="text" name="location" class="input" x-model="formLocation"></div>
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-300"><input type="checkbox" name="all_day" class="accent-primary-500" x-model="formAllDay"> <?= __('event_all_day') ?></label>
                <div class="flex items-center justify-between pt-2">
                    <template x-if="editingEvent">
                        <form method="POST" :action="'<?= url('/agenda/') ?>' + editingEvent.id + '/delete'" onsubmit="return confirm('<?= __('confirm') ?> ?')">
                            <?= csrf_field() ?>
                            <button type="submit" class="text-sm text-red-400 hover:text-red-300"><i class="fas fa-trash mr-1"></i><?= __('delete') ?></button>
                        </form>
                    </template>
                    <div class="flex gap-3 ml-auto">
                        <button type="button" @click="showEventModal = false" class="btn-secondary"><?= __('cancel') ?></button>
                        <button type="submit" class="btn-primary" x-text="editingEvent ? '<?= __('update') ?>' : '<?= __('create') ?>'"></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function calendarApp() {
    const now = new Date();
    const shortDays = ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim'];
    const fullDays = ['Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi','Dimanche'];
    return {
        currentMonth: now.getMonth(), currentYear: now.getFullYear(),
        events: [], showEventModal: false, selectedDate: '', viewMode: 'month',
        editingEvent: null,
        formTitle: '', formDesc: '', formStart: '', formEnd: '', formColor: '#6C3CE1', formLocation: '', formAllDay: false,
        monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
        dayLabels: shortDays,
        resetForm() { this.formTitle=''; this.formDesc=''; this.formStart=this.selectedDate; this.formEnd=''; this.formColor='#6C3CE1'; this.formLocation=''; this.formAllDay=false; },
        get calendarDays() {
            const first = new Date(this.currentYear, this.currentMonth, 1);
            const last = new Date(this.currentYear, this.currentMonth + 1, 0);
            let startDay = first.getDay() || 7;
            const days = [];
            for (let i = startDay - 1; i > 0; i--) {
                const d = new Date(this.currentYear, this.currentMonth, 1 - i);
                days.push(this.makeDay(d, false));
            }
            for (let i = 1; i <= last.getDate(); i++) {
                const d = new Date(this.currentYear, this.currentMonth, i);
                days.push(this.makeDay(d, true));
            }
            const remaining = 42 - days.length;
            for (let i = 1; i <= remaining; i++) {
                const d = new Date(this.currentYear, this.currentMonth + 1, i);
                days.push(this.makeDay(d, false));
            }
            return days;
        },
        get weekDays() {
            const today = new Date();
            const day = today.getDay() || 7;
            const monday = new Date(today); monday.setDate(today.getDate() - day + 1);
            const days = [];
            for (let i = 0; i < 7; i++) {
                const d = new Date(monday); d.setDate(monday.getDate() + i);
                const dm = this.makeDay(d, true);
                dm.dayName = shortDays[i];
                days.push(dm);
            }
            return days;
        },
        get upcomingEvents() {
            const today = new Date().toISOString().split('T')[0];
            return this.events.filter(e => e.start >= today).sort((a,b) => a.start.localeCompare(b.start)).slice(0, 8);
        },
        makeDay(d, isCurrent) {
            const ds = d.toISOString().split('T')[0];
            const today = new Date().toISOString().split('T')[0];
            return { number: d.getDate(), date: ds, key: ds, isCurrentMonth: isCurrent, isToday: ds === today, events: this.events.filter(e => e.start?.startsWith(ds)) };
        },
        formatDate(str) { if (!str) return ''; const d = new Date(str); return d.toLocaleDateString('fr-FR', { weekday:'short', day:'numeric', month:'short', hour:'2-digit', minute:'2-digit' }); },
        async loadEvents() {
            const start = new Date(this.currentYear, this.currentMonth, 1).toISOString().split('T')[0];
            const end = new Date(this.currentYear, this.currentMonth + 1, 0).toISOString().split('T')[0];
            try { const r = await fetch('<?= url('/agenda/events') ?>?start='+start+'&end='+end); this.events = await r.json(); } catch(e) {}
        },
        prevMonth() { if (this.currentMonth === 0) { this.currentMonth = 11; this.currentYear--; } else { this.currentMonth--; } this.loadEvents(); },
        nextMonth() { if (this.currentMonth === 11) { this.currentMonth = 0; this.currentYear++; } else { this.currentMonth++; } this.loadEvents(); },
        goToday() { const n = new Date(); this.currentMonth = n.getMonth(); this.currentYear = n.getFullYear(); this.loadEvents(); },
        selectDate(d) { this.selectedDate = d + 'T09:00'; this.editingEvent = null; this.resetForm(); this.formStart = d + 'T09:00'; this.showEventModal = true; },
        openEditEvent(e) {
            this.editingEvent = e;
            this.formTitle = e.title || '';
            this.formDesc = e.description || '';
            this.formStart = e.start || '';
            this.formEnd = e.end_date || '';
            this.formColor = e.color || '#6C3CE1';
            this.formLocation = e.location || '';
            this.formAllDay = e.all_day == 1;
            this.showEventModal = true;
        }
    }
}
</script>
