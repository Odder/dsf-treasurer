<?php

namespace App\Console\Commands;

use App\Models\Competition;
use App\Services\Wca\Wcif;
use Illuminate\Console\Command;

class MembershipFeeStatistics extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:membership-fee-stats {year?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculates membership fee statistics for a given year.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $year = $this->argument('year');

        $competitions = Competition::when($year, function ($query, $year) {
            $query->whereYear('end_date', $year);
        })
            ->get();

        $personStats = [];

        foreach ($competitions as $competition) {
            $wcif = $competition->wcif;

            if (!$wcif || !collect($wcif->raw)->get('persons')) {
                $this->info("Skipping {$competition->name}");
                continue;
            }

            $participants = $wcif->getCompetitors();
            $nonPayingParticipants = $participants->filter(fn($c) => $c['roles'] && (in_array('organizer', $c['roles']) || in_array('delegate', $c['roles'])));

            foreach ($participants as $participant) {
                $wcaId = $participant['name'] ?? 'Unknown';
                if (!isset($personStats[$wcaId])) {
                    $personStats[$wcaId] = [
                        'wcaId' => $wcaId,
                        'name' => $participant['name'],
                        'total_paid' => 0,
                        'total_skipped' => 0,
                        'membership_fee' => 0,
                    ];
                }
                $personStats[$wcaId]['total_paid']++;
                $personStats[$wcaId]['membership_fee'] += 25;
            }

            foreach ($nonPayingParticipants as $nonPayingParticipant) {
                $wcaId = $nonPayingParticipant['name'] ?? 'Unknown';
                $personStats[$wcaId]['total_skipped']++;
                $personStats[$wcaId]['membership_fee'] -= 25;
            }
        }

        // Filter out people who have paid at least once
//        $personStats = array_filter($personStats, function ($stat) {
//            return in_array($stat['wcaId'], ['2008ANDE02', '2006BUUS01','2013EGDA01', '2017ASMU01', '2015JORG01', '2018KJOL01', '2012GOOD02', '2014GLYR01']);
//        });

        // Sort by total skipped
        usort($personStats, function ($a, $b) {
            return ($b['membership_fee']) - ($a['membership_fee']);
        });

        $this->info("Kontigent Statistics by Person" . ($year ? " for {$year}" : " for all years"));

        $headers = ['WCA ID', 'Navn', 'Antal konkurrencer', 'Ikke opkrævet', 'Kontigent'];
        $data = array_map(function ($stat) {
            return [
                $stat['wcaId'],
                $stat['name'],
                $stat['total_paid'],
                $stat['total_skipped'],
                $stat['membership_fee'],
            ];
        }, $personStats);

        $this->info(count($data));

        $this->table($headers, $data);

        $headers = ['Kontigent', 'Antal Personer', 'Kontigent total'];
        $data = [];

        // Calculate the distribution of kontigent amounts
        $membershipFeeDistribution = collect($personStats)
            ->groupBy(function ($stat) {
                $membershipFee = $stat['membership_fee'];
                if ($membershipFee < 0) {
                    return 'Under 0';
                }
                if ($membershipFee < 100) {
                    return '0-99';
                } elseif ($membershipFee < 200) {
                    return '100-199';
                } elseif ($membershipFee < 300) {
                    return '200-299';
                } elseif ($membershipFee < 400) {
                    return '300-399';
                } elseif ($membershipFee < 500) {
                    return '400-499';
                } else {
                    return '500+';
                }
            })
            ->map(function ($group) {
                return $group->count();
            })
            ->toArray();

        foreach ($membershipFeeDistribution as $range => $count) {
            $data[] = [$range, $count];
        }

        $this->table($headers, $data);

        return Command::SUCCESS;
    }
}
