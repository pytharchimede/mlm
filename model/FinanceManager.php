<?php
class FinanceManager
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function countSubscribedPacksWithTransaction()
    {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM pack_abonne WHERE transaction_hash IS NOT NULL AND transaction_hash != '' AND transaction_hash != 'null'");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getWithdrawalRequests()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM demande_retrait");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllSubscribedPacks()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pack_abonne");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllUsers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveUsers()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM utilisateur WHERE id_utilisateur IN (SELECT DISTINCT abonne_secur FROM pack_abonne WHERE actif = 1)");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveUsersPercentage()
    {
        $stmtTotal = $this->pdo->prepare("SELECT COUNT(*) FROM utilisateur");
        $stmtTotal->execute();
        $totalUsers = $stmtTotal->fetchColumn();

        $stmtActive = $this->pdo->prepare("SELECT COUNT(DISTINCT abonne_secur) FROM pack_abonne WHERE actif = 1");
        $stmtActive->execute();
        $activeUsers = $stmtActive->fetchColumn();

        return $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 2) : 0;
    }

    public function getTotalReversibleAmount()
    {
        $stmt = $this->pdo->prepare("SELECT SUM(solde) FROM pack_abonne");
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
