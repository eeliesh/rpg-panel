<?php
/**
 * @brief TicketsController controller.
 * @authors Lust & Indigo
 * @copyright (c) DreamVibe Community
 * @version 0.1
 */

require_once ROOT_PATH . '/system/Validations/ValidateTicket.php';

class TicketsController extends Controller
{
    private $ticketModel;
    private $privileges;
    private $categoryModel;

    public function __construct()
    {
        global $lang;

        // load the model
        $this->ticketModel = $this->loadModel('Ticket');
        $this->categoryModel = $this->loadModel('Category');

        // store user privileges
        $this->privileges = $this->checkPrivileges();

        if (!isLoggedIn()) {
            flashMessage('danger', $lang['ticket_not_logged_txt']);
            redirect('/');
        }
    }

    public function index()
    {
        global $lang;

        $allTickets = $this->ticketModel->getAllTickets();
        $userTickets = $this->ticketModel->getUserTickets($_SESSION['user_id']);

        if (in_array(1, $this->privileges['canViewTickets'])) {
            $tickets = $allTickets;
        } else {
            $tickets = $userTickets;
        }

        $data = [
            'pageTitle' => 'Panel Tickets',
            'fullAccess' => $this->privileges['fullAccess'],
            'isAdmin' => $this->privileges['isAdmin'],
            'isLeader' => $this->privileges['isLeader'],
            'tickets' => $tickets,
            'lang' => $lang,
            'canViewTickets' => $this->privileges['canViewTickets']
        ];

        $this->loadView('ticket_index', $data);
    }

    public function create()
    {
        global $lang;

        $type = 'ticket';
        $categories = $this->categoryModel->getAllCategories($type);

        if (isset($_POST['create_ticket'])) {
            // sanitize post data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $_POST['ticket_body'] = htmlentities($_POST['ticket_body']);

            $dataPost = [
                'body' => $_POST['ticket_body'],
                'author_id' => $_SESSION['user_id'],
                'author_name' => $_SESSION['user_name'],
                'author_ip' => getUserIp(),
                'category_id' => $_POST['ticket_category']
            ];

            // parse data
            $data = [
                'pageTitle' => 'Create Ticket',
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'ticket' => $dataPost,
                'categories' => $categories,
                'lang' => $lang,
                'ticketBody' => $_POST['ticket_body']
            ];

            // handle errors
            $errors = ValidateTicket::validate($dataPost);

            // check if there are no errors
            if (count(array_filter($errors)) == 0) {
                // create group
                if ($this->ticketModel->createTicket($dataPost)) {
                    flashMessage('success', 'The ticket has been successfully created!');
                    redirect('/tickets');
                } else {
                    die('Something went wrong.');
                }
            } else {
                // load view with errors
                $this->loadView('ticket_create', $data, $errors);
            }
        } else {
            $data = [
                'pageTitle' => 'Create Ticket',
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'ticketBody' => '',
                'ticket' => [
                    'body' => '',
                    'category_id' => 0
                ],
                'categories' => $categories,
                'lang' => $lang
            ];

            // load view
            $this->loadView('ticket_create', $data);
        }
    }

    public function edit($id = 0)
    {
        $ticket = $this->ticketModel->getTicket($id);

        if (empty($id) || $ticket['author_id'] != $_SESSION['user_id'] || $ticket['status'] != 'Open') {
            echo 'Page not found';
        } else {
            global $lang;

            $type = 'ticket';
            $categories = $this->categoryModel->getAllCategories($type);
            $category_name = $this->ticketModel->getCategoryName($ticket['category_id']);

            // check if delete group button is set
            if (isset($_POST['delete_ticket'])) {
                if ($this->ticketModel->deleteTicket($id)) {
                    flashMessage('success', 'Ticket has been successfully deleted!');
                    redirect('/tickets');
                    unset($_POST);
                } else {
                    die('Something went wrong');
                }
            }

            // parse data
            $data = [
                'pageTitle' => 'Create Ticket',
                'fullAccess' => $this->privileges['fullAccess'],
                'isAdmin' => $this->privileges['isAdmin'],
                'isLeader' => $this->privileges['isLeader'],
                'ticket' => $ticket,
                'categories' => $categories,
                'lang' => $lang,
            ];

            if (isset($_POST['edit_ticket'])) {
                // sanitize post data
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                $_POST['ticket_body'] = htmlentities($_POST['ticket_body']);

                $dataPost = [
                    'body' => $_POST['ticket_body'],
                    'category_id' => $_POST['ticket_category'],
                    'edit_ip' => getUserIp()
                ];

                // handle errors
                $errors = ValidateTicket::validate($dataPost);

                // check if there are no errors
                if (count(array_filter($errors)) == 0) {
                    // create group
                    if ($this->ticketModel->editTicket($dataPost, $id)) {
                        flashMessage('success', 'The ticket has been successfully edited!');
                        redirect('/tickets');
                    } else {
                        die('Something went wrong.');
                    }
                } else {
                    // load view with errors
                    $this->loadView('ticket_edit', $data, $errors);
                }
            } else {
                $data = [
                    'pageTitle' => 'Edit Ticket',
                    'fullAccess' => $this->privileges['fullAccess'],
                    'isAdmin' => $this->privileges['isAdmin'],
                    'isLeader' => $this->privileges['isLeader'],
                    'ticketBody' => '',
                    'ticket' => [
                        'body' => $ticket['body'],
                        'category_id' => $ticket['category_id']
                    ],
                    'category_name' => $category_name,
                    'categories' => $categories,
                    'lang' => $lang
                ];

                // load view
                $this->loadView('ticket_edit', $data);
            }
        }
    }
}