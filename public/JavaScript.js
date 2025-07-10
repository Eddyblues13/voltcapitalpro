function UpgradeAccount() {
    swal({
        title: 'success',
        text: 'contact support or Agent for more information',
        type: 'info',
    }, function() {

    });
}

function uploadFile() {
    var files = document.getElementById('customFileLang').files; // $('#file').files[0];// e.target.files;
    if (files.length > 0) {
        if (window.FormData !== undefined) {
            var data = new FormData();
            for (var x = 0; x < files.length; x++) {
                data.append("customFileLang" + x, files[x]);
                //data.append(base64String, base64String);
            }

            $.ajax({
                type: "POST",
                url: '/Account/UploadProof',
                contentType: false,
                processData: false,
                data: data,
                success: function(response) {
                    if (response.success) {
                        swal({
                            title: 'success',
                            text: response.message,
                            type: 'success',
                        }, function() {
                            window.location.href = "/Account/Fund"
                        });

                    } else {
                        swal({
                            title: 'error',
                            text: response.message,
                            type: 'error',
                            button: false

                        });
                    }
                },
                failure: function(response) {
                    $("#loaderbody").addClass('hide');
                    swal(response.responseText);
                },
                error: function(response) {
                    $("#loaderbody").addClass('hide');
                    swal(response.responseText);
                }
            });
        } else {
            alert("Upgrade your browser!");
        }

    } else {
        swal({
            title: 'error',
            text: 'Select a file',
            type: 'error',
            button: false

        });
    }
};

function MembershipVerify() {
    var files = document.getElementById('customFileLang').files; // $('#file').files[0];// e.target.files;
    if (files.length > 0) {
        if (window.FormData !== undefined) {
            var data = new FormData();
            for (var x = 0; x < files.length; x++) {
                data.append("customFileLang" + x, files[x]);
                //data.append(base64String, base64String);
            }

            $.ajax({
                type: "POST",
                url: '/Account/MembershipVerify',
                contentType: false,
                processData: false,
                data: data,
                success: function(response) {
                    if (response.success) {
                        swal({
                            title: 'success',
                            text: response.message,
                            type: 'success',
                        }, function() {
                            window.location.href = "/Account/Withdrawal"
                        });

                    } else {
                        swal({
                            title: 'error',
                            text: response.message,
                            type: 'error',
                            button: false

                        });
                    }
                },
                failure: function(response) {
                    $("#loaderbody").addClass('hide');
                    swal(response.responseText);
                },
                error: function(response) {
                    $("#loaderbody").addClass('hide');
                    swal(response.responseText);
                }
            });
        } else {
            alert("Upgrade your browser!");
        }

    } else {
        swal({
            title: 'error',
            text: 'Select a document',
            type: 'error',
            button: false

        });
    }
};

function btnVipCal() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/CaculateVip",
        data: {
            "amount": $("#VipCalAmount").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                    button: false

                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });

            }

        },
        failure: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        },
        error: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        }
    });
};

function btnGoldCal() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/CaculateGold",
        data: {
            "amount": $("#GoldCalAmount").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                    button: false

                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });

            }


        },
        failure: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        },
        error: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        }
    });
};

function btnSilverCal() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/CaculateSilver",
        data: {
            "amount": $("#SilverCal").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                    button: false

                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });

            }



        },
        failure: function(response) {
            swal(response.responseText);
        },
        error: function(response) {
            swal(response.responseText);
        }
    });
};

function btnBronzeCal() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/CaculateBronze",
        data: {
            "amount": $("#BronzeCal").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                    button: false

                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    timer: 5000,
                    button: false

                });

            }



        },
        failure: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        },
        error: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        }
    });
};

function btnBronzeBuy() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/BuyBronzePlan",
        data: {
            "amount": $("#BronzeBuy").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                }, function() {
                    refreshPage()
                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });
            }



        },
        failure: function(response) {
            swal(response.responseText);
        },
        error: function(response) {
            swal(response.responseText);
        }
    });
};

function btnPromoCal() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/CaculatePromo",
        data: {
            "amount": $("#PromoCal").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                    button: false

                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    timer: 5000,
                    button: false

                });

            }



        },
        failure: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        },
        error: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        }
    });
};

function btnPromoBuy() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/BuyPromoPlan",
        data: {
            "amount": $("#PromoBuy").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                }, function() {
                    refreshPage()
                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });
            }



        },
        failure: function(response) {
            swal(response.responseText);
        },
        error: function(response) {
            swal(response.responseText);
        }
    });
};

function btnVipBuy() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/BuyVipPlan",
        data: {
            "amount": $("#VipBuy").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                }, function() {
                    refreshPage()
                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });
            }


        },
        failure: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        },
        error: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        }
    });
};

function btnGoldBuy() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/BuyGoldPlan",
        data: {
            "amount": $("#GoldBuy").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                }, function() {
                    refreshPage()
                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });
            }



        },
        failure: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        },
        error: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        }
    });
};

function btnSilverBuy() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/BuySilverPlan",
        data: {
            "amount": $("#SilverBuy").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                }, function() {
                    refreshPage()
                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });
            }



        },
        failure: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        },
        error: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        }
    });
};

function btnTransfer() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/ShareFund",
        data: {
            "amount": $("#ShareAmount").val(),
            "receiver": $("#ShareUsername").val(),
            "pin": $("#SharePin").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                }, function() {
                    refreshPage()
                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });

            }



        },
        failure: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        },
        error: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        }
    });
};

function changeWTHmethod() {
    $('.method').hide();
    $('#' + $("#WithdrawalMethod").val()).show();
};

function AmountToBTCValue() {

    $.ajax({
        type: "POST",
        url: "/Account/AmountToBTC",
        data: {
            "amount": $("#txtWTHBTCAmount").val()
        },
        success: function(response) {

            document.getElementById("txtWTHBTCValue").value = response.btcvalue;



        },
        failure: function(response) {
            swal(response.responseText);
        },
        error: function(response) {
            swal(response.responseText);
        }
    });
};

function btnAuthorzieWithdrawalCode() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/AuthorzieWithdrawalCode",
        data: {
            "code": $("#withdrawalcode").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                }, function() {
                    window.location.href = response.url;
                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',

                    button: false

                });

            }


        },
        failure: function(response) {
            swal(response.responseText);
        },
        error: function(response) {
            swal(response.responseText);
        }
    });
};

function refreshPage() {
    location.reload(true);
}

function btnBANKWITHDRAWAL() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/BankWithdrawal",
        data: {
            "amount": $("#txtWTHBNKAmount").val(),
            "bankname": $("#txtWTHBankName").val(),
            "accountnumber": $("#txtWTHAccountNumber").val(),
            "accountname": $("#txtWTHAccountName").val(),
            "swiftcode": $("#txtWTHSwiftCode").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                }, function() {
                    refreshPage()
                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',

                    button: false

                });

            }



        },
        failure: function(response) {
            swal(response.responseText);
        },
        error: function(response) {
            swal(response.responseText);
        }
    });
};

function btnBTCWITHDRAWAL() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/BTCWithdrawal",
        data: {
            "amount": $("#txtWTHBTCAmount").val(),
            "walletaddress": $("#txtWTHWalletAddress").val(),
            "wallettype": $("#txtWTHWalletType").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                }, function() {
                    refreshPage()
                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',

                    button: false

                });

            }



        },
        failure: function(response) {
            swal(response.responseText);
        },
        error: function(response) {
            swal(response.responseText);
        }
    });
};

function btnChangePassword() {
    //Set the URL.
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: 'POST',
        url: "/Account/ChangePassword",
        data: {
            "OldPassword": $("#txtOldPassword").val(),
            "NewPassword": $("#txtNewPassword").val(),
            "ConfirmPassword": $("#txtConfirmPassword").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                }, function() {
                    refreshPage()
                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });
            }
        }


    });
}

function btnChangePin() {
    //Set the URL.

    $("#loaderbody").removeClass('hide');

    $.ajax({
        type: 'POST',
        url: "/Account/ChangePin",
        data: {
            "OldPin": $("#OldPin").val(),
            "NewPin": $("#NewPin").val(),
            "ConfirmPin": $("#ConfirmPin").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                }, function() {
                    refreshPage()
                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });
            }
        }
    });
}

function BTCPreview() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/FundBTC",
        data: {
            "amount": $("#txtBTCPreview").val()
        },
        success: function(response) {
            if (response.success) {
                window.location.replace(response.url);
            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });

            }



        },
        failure: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        },
        error: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        }
    });
};

function ETHPreview() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/FundETH",
        data: {
            "amount": $("#txtETHPreview").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                window.location.replace(response.url);
            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });

            }



        },
        failure: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        },
        error: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        }
    });
};

function USDTPreview() {
    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: "POST",
        url: "/Account/FundUSDT",
        data: {
            "amount": $("#txtUSDTPreview").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                window.location.replace(response.url);
            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });

            }



        },
        failure: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        },

        error: function(response) {
            $("#loaderbody").addClass('hide');
            swal(response.responseText);
        }
    });
};


function btnFundTransfer() {
    //Set the URL.


    $("#loaderbody").removeClass('hide');
    $.ajax({
        type: 'POST',
        url: "/Account/FundTransfer",
        data: {
            "amount": $("#txtFundAmount").val(),
            "account": $("#SelectAccount").val()
        },
        success: function(response) {
            $("#loaderbody").addClass('hide');
            if (response.success) {
                swal({
                    title: 'success',
                    text: response.message,
                    type: 'success',
                }, function() {
                    refreshPage()
                });

            } else {
                swal({
                    title: 'error',
                    text: response.message,
                    type: 'error',
                    button: false

                });
            }
        }
    });
}

function CopyLink() {
    //alert()
    var copyText = document.getElementById("ReferralLink");
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");
    swal({
        title: 'success',
        text: 'Referral Link Copied',
        type: 'success',
        button: false
    });
}

function CopyBTCWallet() {
    //alert()
    var copyText = document.getElementById("BTCWallet");
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");
    swal({
        title: 'success',
        text: 'Wallet Address Copied',
        type: 'success',
        button: false
    });
}

function CopyETHWallet() {
    //alert()
    var copyText = document.getElementById("ETHWallet");
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");
    swal({
        title: 'success',
        text: 'Wallet Address Copied',
        type: 'success',
        button: false
    });
}

function CopyUSDTWallet() {
    //alert()
    var copyText = document.getElementById("USDTWallet");
    copyText.select();
    copyText.setSelectionRange(0, 99999)
    document.execCommand("copy");
    swal({
        title: 'success',
        text: 'Wallet Address Copied',
        type: 'success',
        button: false
    });
}

function CancleWithdrawal(url) {
    if (confirm('Are you sure to  Cancle this Withdrawal ?') == true) {
        $("#loaderbody").removeClass('hide');
        $.ajax({
            type: 'POST',
            url: url,
            success: function(response) {
                $("#loaderbody").addClass('hide');
                if (response.success) {
                    swal({
                        title: 'success',
                        text: response.message,
                        type: 'success',
                    }, function() {
                        refreshPage()
                    });

                } else {
                    swal({
                        title: 'error',
                        text: response.message,
                        type: 'error',
                        button: false

                    });

                }
            }
        });

    }
}

function ApproveWithdrawal(url) {
    if (confirm('Are you sure to approve this withdrawal request ?') == true) {
        $("#loaderbody").removeClass('hide');
        $.ajax({
            type: 'POST',
            url: url,
            success: function(response) {
                $("#loaderbody").addClass('hide');
                if (response.success) {
                    swal({
                        title: 'success',
                        text: response.message,
                        type: 'success',
                    }, function() {
                        refreshPage()
                    });

                } else {
                    swal({
                        title: 'error',
                        text: response.message,
                        type: 'error',
                        button: false

                    });
                }
            }
        });

    }
}

function ApproveDeposit(url) {
    if (confirm('Are you sure to  Confirm this Deposit ?') == true) {
        $("#loaderbody").removeClass('hide');
        $.ajax({
            type: 'POST',
            url: url,
            success: function(response) {
                $("#loaderbody").addClass('hide');
                if (response.success) {
                    swal({
                        title: 'success',
                        text: response.message,
                        type: 'success',
                    }, function() {
                        refreshPage()
                    });

                } else {
                    swal({
                        title: 'error',
                        text: response.message,
                        type: 'error',
                        button: false

                    });

                }
            }
        });

    }
}

function CancleDeposit(url) {
    if (confirm('Are you sure to Cancled this Deposit ?') == true) {
        $("#loaderbody").removeClass('hide');
        $.ajax({
            type: 'POST',
            url: url,
            success: function(response) {
                $("#loaderbody").addClass('hide');
                if (response.success) {
                    swal({
                        title: 'success',
                        text: response.message,
                        type: 'success',
                    }, function() {
                        refreshPage()
                    });

                } else {
                    swal({
                        title: 'error',
                        text: response.message,
                        type: 'error',
                        button: false

                    });
                }
            }

        });

    }
}

function ReverseDeposit(url) {
    if (confirm('Are you sure to Delete Record ?') == true) {
        $("#loaderbody").removeClass('hide');
        $.ajax({
            type: 'POST',
            url: url,
            success: function(response) {
                $("#loaderbody").addClass('hide');
                if (response.success) {
                    swal({
                        title: 'success',
                        text: response.message,
                        type: 'success',
                    }, function() {
                        refreshPage()
                    });

                } else {
                    swal({
                        title: 'error',
                        text: response.message,
                        type: 'error',
                        button: false

                    });
                }
            }
        });

    }
}

function DailyTrade(url) {
    if (confirm('Are you sure to make Daily Top-Up ?') == true) {
        $("#loaderbody").removeClass('hide');
        $.ajax({
            type: 'POST',
            url: url,
            success: function(response) {
                $("#loaderbody").addClass('hide');
                if (response.success) {
                    swal({
                        title: 'success',
                        text: response.message,
                        type: 'success',
                    }, function() {
                        refreshPage()
                    });

                } else {
                    swal({
                        title: 'error',
                        text: response.message,
                        type: 'error',
                        button: false

                    });
                }
            }
        });

    }
}

function DeleteDeposit(url) {
    if (confirm('Are you sure to Delete Record ?') == true) {
        $("#loaderbody").removeClass('hide');
        $.ajax({
            type: 'POST',
            url: url,
            success: function(response) {
                $("#loaderbody").addClass('hide');
                if (response.success) {
                    swal({
                        title: 'success',
                        text: response.message,
                        type: 'success',
                    }, function() {
                        refreshPage()
                    });

                } else {
                    swal({
                        title: 'error',
                        text: response.message,
                        type: 'error',
                        button: false

                    });
                }
            }
        });

    }
}

function DeletePlan(url) {
    if (confirm('Are you sure to Delete Record ?') == true) {
        $("#loaderbody").removeClass('hide');
        $.ajax({
            type: 'POST',
            url: url,
            success: function(response) {
                $("#loaderbody").addClass('hide');
                if (response.success) {
                    swal({
                        title: 'success',
                        text: response.message,
                        type: 'success',
                    }, function() {
                        refreshPage()
                    });

                } else {
                    swal({
                        title: 'error',
                        text: response.message,
                        type: 'error',
                        button: false

                    });
                }
            }
        });

    }
}

function DeletWithdrawal(url) {
    if (confirm('Are you sure to Delete Record ?') == true) {
        $("#loaderbody").removeClass('hide');
        $.ajax({
            type: 'POST',
            url: url,
            success: function(response) {
                $("#loaderbody").addClass('hide');
                if (response.success) {
                    swal({
                        title: 'success',
                        text: response.message,
                        type: 'success',
                    }, function() {
                        refreshPage()
                    });

                } else {
                    swal({
                        title: 'error',
                        text: response.message,
                        type: 'error',
                        button: false

                    });
                }
            }
        });

    }
}

function ActivatePlan(url) {
    if (confirm('Are you sure to Activate Plan ?') == true) {
        $("#loaderbody").removeClass('hide');
        $.ajax({
            type: 'POST',
            url: url,
            success: function(response) {
                $("#loaderbody").addClass('hide');
                if (response.success) {
                    swal({
                        title: 'success',
                        text: response.message,
                        type: 'success',
                    }, function() {
                        refreshPage()
                    });

                } else {
                    swal({
                        title: 'error',
                        text: response.message,
                        type: 'error',
                        button: false

                    });
                }
            }
        });

    }
}


function DeactivatePlan(url) {
    if (confirm('Are you sure to DeActivate Plan ?') == true) {
        $("#loaderbody").removeClass('hide');
        $.ajax({
            type: 'POST',
            url: url,
            success: function(response) {
                $("#loaderbody").addClass('hide');
                if (response.success) {
                    swal({
                        title: 'success',
                        text: response.message,
                        type: 'success',
                    }, function() {
                        refreshPage()
                    });

                } else {
                    swal({
                        title: 'error',
                        text: response.message,
                        type: 'error',
                        button: false

                    });
                }
            }
        });

    }
}

function SingTop(url) {
    if (confirm('Are you sure to Toup Record ?') == true) {
        $("#loaderbody").removeClass('hide');
        $.ajax({
            type: 'POST',
            url: url,
            success: function(response) {
                $("#loaderbody").addClass('hide');
                if (response.success) {
                    swal({
                        title: 'success',
                        text: response.message,
                        type: 'success',
                    }, function() {
                        refreshPage()
                    });

                } else {
                    swal({
                        title: 'error',
                        text: response.message,
                        type: 'error',
                        button: false

                    });
                }
            }
        });

    }
}