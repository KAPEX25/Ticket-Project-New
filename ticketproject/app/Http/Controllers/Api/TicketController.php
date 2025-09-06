<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    // LISTE + FİLTRELER
    public function index(Request $request)
    {
        $user = $request->user();
        $query = Ticket::query();

        // Rol kontrolü (user kendi ticketlarını görsün)
        if (! $user->hasRole('admin') && ! $user->hasRole('agent')) {
            $query->where('created_by_user_id', $user->id);
        }

        // Filtreler
        if ($request->filled('status')) {
            $statuses = explode(',', $request->status);
            $query->whereIn('status', $statuses);
        }
        if ($request->filled('priority')) {
            $priorities = explode(',', $request->priority);
            $query->whereIn('priority', $priorities);
        }
        if ($request->filled('category')) {
            $categories = explode(',', $request->category);
            $query->whereIn('category', $categories);
        }
        if ($request->filled('impact')) {
            $impacts = explode(',', $request->impact);
            $query->whereIn('impact', $impacts);
        }
        if ($request->filled('source')) {
            $sources = explode(',', $request->source);
            $query->whereIn('source', $sources);
        }
        if ($request->filled('assigned_user_id')) {
            $query->where('assigned_user_id', $request->assigned_user_id);
        }
        if ($request->filled('created_by_user_id')) {
            $query->where('created_by_user_id', $request->created_by_user_id);
        }
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function($sub) use ($q) {
                $sub->where('title', 'like', "%$q%")
                    ->orWhere('description', 'like', "%$q%");
            });
        }
        if ($request->filled('overdue') && $request->overdue == 1) {
            $query->where('sla_due_date', '<', now());
        }

        // Sıralama
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Sayfalama
        $perPage = $request->get('per_page', 10);
        return $query->paginate($perPage);
    }

    // OLUŞTUR
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|string',
            'category' => 'required|string',
            'impact' => 'nullable|string',
            'source' => 'nullable|string',
        ]);

        $data['status'] = 'open';
        $data['created_by_user_id'] = $request->user()->id;

        $ticket = Ticket::create($data);

        return response()->json($ticket, 201);
    }

    // DETAY
    public function show(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        if ($user->hasRole('admin') || $user->hasRole('agent') || $ticket->created_by_user_id == $user->id) {
            return response()->json($ticket);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // GÜNCELLE
    public function update(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        if (! $user->hasRole('admin') && ! $user->hasRole('agent')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $ticket->update($request->only([
            'status',
            'priority',
            'impact',
            'category',
            'source'
        ]));

        // resolved işleme mantığı
        if ($ticket->status === 'resolved' && is_null($ticket->resolved_at)) {
            $ticket->resolved_at = now();
            $ticket->assigned_user_id = $user->id;
            $ticket->save();
        }

        return response()->json($ticket);
    }

    // SİL (opsiyonel)
    public function destroy(Request $request, Ticket $ticket)
    {
        if (! $request->user()->hasRole('admin')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $ticket->delete();

        return response()->json(['message' => 'Ticket deleted']);
    }

    // ÖZEL: ASSIGN
    public function assign(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        if (! $user->hasRole('admin') && ! $user->hasRole('agent')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'assigned_user_id' => 'required|exists:users,id'
        ]);

        $ticket->assigned_user_id = $request->assigned_user_id;
        $ticket->save();

        return response()->json($ticket);
    }

    // ÖZEL: RESOLVE
    public function resolve(Request $request, Ticket $ticket)
    {
        $user = $request->user();

        if (! $user->hasRole('admin') && ! $user->hasRole('agent')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $ticket->status = 'resolved';
        $ticket->resolved_at = now();
        $ticket->assigned_user_id = $user->id;
        $ticket->save();

        return response()->json($ticket);
    }
}
