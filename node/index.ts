// Node.js
import axios from 'axios';

// Definir a URL base da API
const BASE_URL = 'https://api.pineapplepay.co';

// Interfaces para os corpos das requisições
interface PaymentRequest {
  name: string;
  email: string;
  document: string;
  description: string;
  amount: number;
  postbackUrl: string;
}

interface RefundRequest {
  transactionId: string;
  description: string;
}

interface WithdrawRequest {
  amount: number;
  name: string;
  document: string;
  description: string;
  key: string;
  keyType: string;
}

// Configuração dos cabeçalhos
function getHeaders(clientId: string, clientSecret: string) {
  return {
    'Content-Type': 'application/json',
    'x-client-id': clientId,
    'x-client-secret': clientSecret
  };
}

// Criar transação
async function createTransaction(clientId: string, clientSecret: string, data: PaymentRequest) {
  try {
    const response = await axios.post(`${BASE_URL}/v1/payment`, data, {
      headers: getHeaders(clientId, clientSecret)
    });
    console.log('Transação criada:', response.data);
    return response.data;
  } catch (error) {
    console.error('Erro ao criar transação:', error);
  }
}

// Estornar transação
async function refundTransaction(clientId: string, clientSecret: string, data: RefundRequest) {
  try {
    const response = await axios.post(`${BASE_URL}/v1/refund`, data, {
      headers: getHeaders(clientId, clientSecret)
    });
    console.log('Transação estornada:', response.data);
    return response.data;
  } catch (error) {
    console.error('Erro ao estornar transação:', error);
  }
}

// Buscar transação
async function getTransaction(clientId: string, clientSecret: string, id: string) {
  try {
    const response = await axios.get(`${BASE_URL}/v1/payment/${id}`, {
      headers: getHeaders(clientId, clientSecret)
    });
    console.log('Transação encontrada:', response.data);
    return response.data;
  } catch (error) {
    console.error('Erro ao buscar transação:', error);
  }
}

// Fazer transferência
async function makeTransfer(clientId: string, clientSecret: string, data: WithdrawRequest) {
  try {
    const response = await axios.post(`${BASE_URL}/v1/withdraw`, data, {
      headers: getHeaders(clientId, clientSecret)
    });
    console.log('Transferência realizada:', response.data);
    return response.data;
  } catch (error) {
    console.error('Erro ao fazer transferência:', error);
  }
}

// Exportar funções
export { createTransaction, refundTransaction, getTransaction, makeTransfer };
