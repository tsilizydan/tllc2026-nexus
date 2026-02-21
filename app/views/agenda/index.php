<?php $pageTitle = __('agenda'); ?>
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-white"><i class="fas fa-calendar-alt text-accent-400 mr-3"></i><?= __('agenda') ?></h1>
    <button @click="showEventModal = true" class="btn-primary inline-flex items-center gap-2 text-sm"><i class="fas fa-plus"></i>Nouvel événement</button>
</div>

<div x-data="calendarApp()" class="card p-6" x-init="loadEvents()">
    <!-- Calendar Header -->
    <div class="flex items-center justify-between mb-6">
        <button @click="prevMonth()" class="btn-secondary text-sm"><i class="fas fa-chevron-left"></i></button>
        <h2 class="text-lg font-semibold text-white" x-text="monthNames[currentMonth] + ' ' + currentYear"></h2>
        <button @click="nextMonth()" class="btn-secondary text-sm"><i class="fas fa-chevron-right"></i></button>
    </div>

    <!-- Days Header -->
    <div class="grid grid-cols-7 mb-2">
        <template x-for="day in ['Lun','Mar','Mer','Jeu','Ven','Sam','Dim']">
            <div class="py-2 text-center text-xs font-medium text-slate-500" x-text="day"></div>
        </template>
    </div>

    <!-- Calendar Grid -->
    <div class="grid grid-cols-7 gap-1">
        <template x-for="day in calendarDays" :key="day.key">
            <div class="min-h-[80px] p-1.5 rounded-lg transition-colors cursor-pointer"
                 :class="{
                     'bg-white/5': day.isCurrentMonth,
                     'opacity-40': !day.isCurrentMonth,
                     'ring-1 ring-primary-500/50': day.isToday
                 }"
                 @click="selectDate(day.date)">
                <span class="text-xs font-medium" :class="day.isToday ? 'text-primary-400' : 'text-slate-400'" x-text="day.number"></span>
                <div class="mt-1 space-y-0.5">
                    <template x-for="event in day.events">
                        <div class="text-[10px] px-1.5 py-0.5 rounded truncate cursor-pointer"
                             :style="'background:' + (event.color || '#6C3CE1') + '30; color:' + (event.color || '#6C3CE1')"
                             @click.stop="editEvent(event)" x-text="event.title"></div>
                    </template>
                </div>
            </div>
        </template>
    </div>

    <!-- New Event Modal -->
    <div x-show="showEventModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" x-transition>
        <div class="absolute inset-0 bg-black/60" @click="showEventModal = false"></div>
        <div class="relative glass-solid rounded-2xl w-full max-w-md p-6" @click.stop>
            <h3 class="text-lg font-semibold text-white mb-4">Nouvel événement</h3>
            <form method="POST" action="<?= url('/agenda') ?>" class="space-y-4">
                <?= csrf_field() ?>
                <div><label class="block text-sm text-slate-300 mb-1">Titre *</label><input type="text" name="title" class="input" required></div>
                <div><label class="block text-sm text-slate-300 mb-1">Description</label><textarea name="description" rows="2" class="input"></textarea></div>
                <div class="grid grid-cols-2 gap-3">
                    <div><label class="block text-sm text-slate-300 mb-1">Début</label><input type="datetime-local" name="start_date" class="input" :value="selectedDate" required></div>
                    <div><label class="block text-sm text-slate-300 mb-1">Fin</label><input type="datetime-local" name="end_date" class="input"></div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div><label class="block text-sm text-slate-300 mb-1">Couleur</label><input type="color" name="color" value="#6C3CE1" class="w-full h-10 rounded-lg cursor-pointer bg-transparent border border-white/10"></div>
                    <div><label class="block text-sm text-slate-300 mb-1">Lieu</label><input type="text" name="location" class="input"></div>
                </div>
                <label class="flex items-center gap-2 text-sm text-slate-300"><input type="checkbox" name="all_day" class="accent-primary-500"> Journée entière</label>
                <div class="flex justify-end gap-3 pt-2"><button type="button" @click="showEventModal = false" class="btn-secondary">Annuler</button><button type="submit" class="btn-primary">Créer</button></div>
            </form>
        </div>
    </div>
</div>

<script>
function calendarApp() {
    const now = new Date();
    return {
        currentMonth: now.getMonth(), currentYear: now.getFullYear(),
        events: [], showEventModal: false, selectedDate: '',
        monthNames: ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'],
        get calendarDays() {
            const first = new Date(this.currentYear, this.currentMonth, 1);
            const last = new Date(this.currentYear, this.currentMonth + 1, 0);
            let startDay = first.getDay() || 7; // Mon=1
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
        makeDay(d, isCurrent) {
            const ds = d.toISOString().split('T')[0];
            const today = new Date().toISOString().split('T')[0];
            return { number: d.getDate(), date: ds, key: ds, isCurrentMonth: isCurrent, isToday: ds === today, events: this.events.filter(e => e.start?.startsWith(ds)) };
        },
        async loadEvents() {
            const start = new Date(this.currentYear, this.currentMonth, 1).toISOString().split('T')[0];
            const end = new Date(this.currentYear, this.currentMonth + 1, 0).toISOString().split('T')[0];
            try { const r = await fetch('<?= url('/agenda/events') ?>?start='+start+'&end='+end); this.events = await r.json(); } catch(e) {}
        },
        prevMonth() { if (this.currentMonth === 0) { this.currentMonth = 11; this.currentYear--; } else { this.currentMonth--; } this.loadEvents(); },
        nextMonth() { if (this.currentMonth === 11) { this.currentMonth = 0; this.currentYear++; } else { this.currentMonth++; } this.loadEvents(); },
        selectDate(d) { this.selectedDate = d + 'T09:00'; this.showEventModal = true; },
        editEvent(e) { window.location.href = '<?= url('/agenda/') ?>' + e.id + '/edit'; }
    }
}
</script>
