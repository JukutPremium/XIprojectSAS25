<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Kelas;
use App\Models\Jurusan;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'Siswa';
    protected static ?string $pluralModelLabel = 'Siswa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nis_siswa')
                    ->unique(ignorable: fn($record) => $record)
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->label('NIS Siswa'),
                Forms\Components\TextInput::make('nama_siswa')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Siswa'),
                Forms\Components\TextInput::make('absen_siswa')
                    ->required()
                    ->numeric()
                    ->label('Nomor Absen'),
                Forms\Components\Select::make('id_jurusan_siswa')
                    ->relationship('jurusan', 'nama_jurusan')
                    ->required()
                    ->label('Jurusan')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('id_kelas_siswa', null)),
                Forms\Components\Select::make('id_kelas_siswa')
                    ->label('Kelas')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->options(function (callable $get) {
                        $jurusanId = $get('id_jurusan_siswa');
                        if (!$jurusanId) {
                            return [];
                        }
                        return Kelas::where('id_jurusan_kelas', $jurusanId)
                            ->pluck('nama_kelas', 'id_kelas');
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nis_siswa')
                    ->label('NIS')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_siswa')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('absen_siswa')
                    ->label('No. Absen')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kelas.nama_kelas')
                    ->label('Kelas')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jurusan.nama_jurusan')
                    ->label('Jurusan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('id_jurusan_siswa')
                    ->relationship('jurusan', 'nama_jurusan')
                    ->label('Filter by Jurusan'),
                Tables\Filters\SelectFilter::make('id_kelas_siswa')
                    ->relationship('kelas', 'nama_kelas')
                    ->label('Filter by Kelas'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}