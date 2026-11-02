<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AppNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;

class BackupRestoreController extends Controller
{
    public function index()
    {
        $backups = collect(Storage::disk('local')->files('backups/admin'))
            ->filter(fn (string $file) => str_ends_with($file, '.sql'))
            ->sortDesc()
            ->values();

        return view('admin.backup-restore.index', compact('backups'));
    }

    public function backup()
    {
        $config = config('database.connections.mysql');
        $filename = 'backup-'.now()->format('Ymd-His').'.sql';
        $path = storage_path('app/backups/admin/'.$filename);

        Storage::disk('local')->makeDirectory('backups/admin');

        $command = [
            'C:\\xampp\\mysql\\bin\\mysqldump.exe',
            '--host='.$config['host'],
            '--port='.$config['port'],
            '--user='.$config['username'],
        ];
        if (! empty($config['password'])) {
            $command[] = '--password='.$config['password'];
        }
        $command[] = $config['database'];
        $command[] = '--result-file='.$path;

        $process = new Process($command);
        $process->setTimeout(120);
        $process->run();

        if (! $process->isSuccessful()) {
            return back()->withErrors(['backup' => 'Backup gagal: '.$process->getErrorOutput()]);
        }

        ActivityLog::record('backup', 'backup-restore', null, [], ['file' => $filename]);
        AppNotification::notifyAdmins('Backup database dibuat', $filename, route('admin.backup-restore.index'));

        return back()->with('success', 'Backup database berhasil dibuat.');
    }

    public function download(string $file)
    {
        $path = 'backups/admin/'.basename($file);
        abort_unless(Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->download($path);
    }

    public function restore(Request $request)
    {
        $data = $request->validate([
            'backup_file' => ['required', 'file', 'mimes:sql,txt'],
        ]);

        $config = config('database.connections.mysql');
        $path = $data['backup_file']->store('backups/admin/uploads');
        $fullPath = storage_path('app/'.$path);

        $command = [
            'C:\\xampp\\mysql\\bin\\mysql.exe',
            '--host='.$config['host'],
            '--port='.$config['port'],
            '--user='.$config['username'],
        ];
        if (! empty($config['password'])) {
            $command[] = '--password='.$config['password'];
        }
        $command[] = $config['database'];

        $process = new Process($command);
        $process->setInput(file_get_contents($fullPath));
        $process->setTimeout(180);
        $process->run();

        if (! $process->isSuccessful()) {
            return back()->withErrors(['restore' => 'Restore gagal: '.$process->getErrorOutput()]);
        }

        DB::reconnect();
        ActivityLog::record('restore', 'backup-restore', null, [], ['file' => basename($fullPath)]);
        AppNotification::notifyAdmins('Restore database selesai', basename($fullPath), route('admin.backup-restore.index'));

        return back()->with('success', 'Restore database berhasil dijalankan.');
    }
}
