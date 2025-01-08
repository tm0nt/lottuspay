import requests
from typing import Optional, Dict, Any

class PineapplePayClient:
    BASE_URL = "https://api.lottuspay.com"

    def __init__(self, client_id: str, client_secret: str) -> None:
        self.client_id = client_id
        self.client_secret = client_secret
        self.headers = {
            "Content-Type": "application/json",
            "x-client-id": self.client_id,
            "x-client-secret": self.client_secret,
        }

    def create_transaction(self, data: Dict[str, Any]) -> Optional[Dict[str, Any]]:
        """
        Cria uma nova transação de pagamento.

        Exemplo de data:
        {
          "name": "Fulano de Tal",
          "email": "fulano@example.com",
          "document": "00000000000",
          "description": "Serviço X",
          "amount": 1000,
          "postbackUrl": "https://minhaurl.com/postback"
        }
        """
        try:
            response = requests.post(
                f"{self.BASE_URL}/v1/payment",
                json=data,
                headers=self.headers
            )
            response.raise_for_status()
            return response.json()
        except requests.exceptions.RequestException as e:
            # Logar erro, se desejar
            return None

    def refund_transaction(self, data: Dict[str, Any]) -> Optional[Dict[str, Any]]:
        """
        Estorna uma transação existente.

        Exemplo de data:
        {
          "transactionId": "abc123",
          "description": "Motivo do estorno"
        }
        """
        try:
            response = requests.post(
                f"{self.BASE_URL}/v1/refund",
                json=data,
                headers=self.headers
            )
            response.raise_for_status()
            return response.json()
        except requests.exceptions.RequestException as e:
            # Logar erro, se desejar
            return None

    def get_transaction(self, transaction_id: str) -> Optional[Dict[str, Any]]:
        """
        Busca detalhes de uma transação, identificada por seu ID.
        """
        try:
            response = requests.get(
                f"{self.BASE_URL}/v1/payment/{transaction_id}",
                headers=self.headers
            )
            response.raise_for_status()
            return response.json()
        except requests.exceptions.RequestException as e:
            # Logar erro, se desejar
            return None

    def make_transfer(self, data: Dict[str, Any]) -> Optional[Dict[str, Any]]:
        """
        Realiza uma transferência (withdraw).

        Exemplo de data:
        {
          "amount": 1000,
          "name": "Fulano de Tal",
          "document": "00000000000",
          "description": "Transferência para Fulano",
          "key": "fulano@exemplo.com",
          "keyType": "email"
        }
        """
        try:
            response = requests.post(
                f"{self.BASE_URL}/v1/withdraw",
                json=data,
                headers=self.headers
            )
            response.raise_for_status()
            return response.json()
        except requests.exceptions.RequestException as e:
            # Logar erro, se desejar
            return None
